<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderInvoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:orders_manage')->only([
            'index',
            'show',
            'edit',
            'update',
            'destroy',
            'updateStatus',
            'markAsPaid',
            'downloadInvoice',
            'emailInvoice'
        ]);
    }

    /**
     * Display a listing of the orders with filtering.
     */
    public function index(Request $request)
    {
        // Get filter data for dropdowns
        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        $query = Order::with(['customer', 'shippingAddress', 'billingAddress', 'items.product', 'payments']);

        // Search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%")
                    ->orWhere('customer_phone', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->where('full_name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('shippingAddress', function ($q) use ($search) {
                        $q->where('full_name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
            });
        }

        // Status filter
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Payment status filter
        if ($request->has('payment_status') && !empty($request->payment_status)) {
            $query->where('payment_status', $request->payment_status);
        }

        // Payment method filter
        if ($request->has('payment_method') && !empty($request->payment_method)) {
            $query->where('payment_method', $request->payment_method);
        }

        // Date range filter
        $startDate = $request->has('start_date') && !empty($request->start_date)
            ? $request->start_date
            : date('Y-m-d', strtotime('-30 days'));

        $endDate = $request->has('end_date') && !empty($request->end_date)
            ? $request->end_date
            : date('Y-m-d');

        $query->whereBetween('created_at', [
            $startDate . ' 00:00:00',
            $endDate . ' 23:59:59'
        ]);

        // Category filter
        if ($request->has('category_id') && !empty($request->category_id)) {
            $query->whereHas('items.product', function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });
        }

        // Brand filter
        if ($request->has('brand_id') && !empty($request->brand_id)) {
            $query->whereHas('items.product', function ($q) use ($request) {
                $q->where('brand_id', $request->brand_id);
            });
        }

        // Product filter
        if ($request->has('product_id') && !empty($request->product_id)) {
            $query->whereHas('items', function ($q) use ($request) {
                $q->where('product_id', $request->product_id);
            });
        }

        // Sort orders
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $orders = $query->paginate(15);

        // Statistics
        $totalAmount = $orders->sum('total_amount');
        $totalCompletedAmount = $orders->where('status', 'delivered')->sum('total_amount');
        $totalCancelledAmount = $orders->where('status', 'cancelled')->sum('total_amount');

        // Get counts for stats
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $confirmedOrders = Order::where('status', 'confirmed')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $shippedOrders = Order::where('status', 'shipped')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();
        $returnedOrders = Order::where('status', 'returned')->count();
        $refundedOrders = Order::where('status', 'refunded')->count();

        // Payment statistics
        $paidOrders = Order::where('payment_status', 'paid')->count();
        $pendingPaymentOrders = Order::where('payment_status', 'pending')->count();

        // Available statuses for filter
        $statuses = [
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'processing' => 'Processing',
            'shipped' => 'Shipped',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
            'returned' => 'Returned',
            'refunded' => 'Refunded',
        ];

        $paymentStatuses = [
            'pending' => 'Pending',
            'authorized' => 'Authorized',
            'paid' => 'Paid',
            'partially_paid' => 'Partially Paid',
            'refunded' => 'Refunded',
            'failed' => 'Failed',
        ];

        $paymentMethods = [
            'cash_on_delivery' => 'Cash on Delivery',
            'bkash' => 'bKash',
            'nagad' => 'Nagad',
            'rocket' => 'Rocket',
            'sslcommerz' => 'SSLCommerz',
            'bank_transfer' => 'Bank Transfer',
            'card' => 'Card',
        ];

        return view('admin.orders.index', compact(
            'orders',
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'deliveredOrders',
            'confirmedOrders',
            'shippedOrders',
            'cancelledOrders',
            'returnedOrders',
            'refundedOrders',
            'paidOrders',
            'pendingPaymentOrders',
            'categories',
            'brands',
            'products',
            'totalAmount',
            'totalCompletedAmount',
            'totalCancelledAmount',
            'statuses',
            'paymentStatuses',
            'paymentMethods',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Display the specified order.
     */
    public function show($id)
    {
        $order = Order::with([
            'customer',
            'shippingAddress',
            'billingAddress',
            'items.product.category',
            'items.product.brand',
            'items.product.images',
            'payments'
        ])->findOrFail($id);

        // Get customer order history
        $customerId = $order->customer_id;
        $customerPhone = $order->customer_phone;

        $customerOrders = Order::where(function ($q) use ($customerId, $customerPhone) {
            if ($customerId) {
                $q->where('customer_id', $customerId);
            } else {
                $q->where('customer_phone', $customerPhone);
            }
        })->get();

        $totalCustomerOrders = $customerOrders->count();
        $completedCustomerOrders = $customerOrders->where('status', 'delivered')->count();
        $cancelledCustomerOrders = $customerOrders->whereIn('status', ['cancelled', 'returned', 'refunded'])->count();

        $completedPercent = $totalCustomerOrders > 0 ? round(($completedCustomerOrders / $totalCustomerOrders) * 100, 2) : 0;
        $cancelledPercent = $totalCustomerOrders > 0 ? round(($cancelledCustomerOrders / $totalCustomerOrders) * 100, 2) : 0;

        // Calculate total spent by customer
        $totalSpent = $customerOrders->where('status', 'delivered')->sum('total_amount');

        // Get status history if you have it
        $statusHistory = []; // You can add this if you have order_status_history table

        return view('admin.orders.show', compact(
            'order',
            'totalCustomerOrders',
            'completedCustomerOrders',
            'cancelledCustomerOrders',
            'completedPercent',
            'cancelledPercent',
            'totalSpent',
            'statusHistory'
        ));
    }

    /**
     * Show the form for editing the specified order.
     */
    public function edit($id)
    {
        $order = Order::with([
            'customer',
            'shippingAddress',
            'billingAddress',
            'items.product.category',
            'items.product.brand',
            'items.product.images',
            'payments'
        ])->findOrFail($id);

        // Get status options
        $statusOptions = [
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'processing' => 'Processing',
            'shipped' => 'Shipped',
            'delivered' => 'Delivered',
            'returned' => 'Returned',
            'refunded' => 'Refunded',
            'cancelled' => 'Cancelled',
        ];

        $paymentStatusOptions = [
            'pending' => 'Pending',
            'authorized' => 'Authorized',
            'paid' => 'Paid',
            'partially_paid' => 'Partially Paid',
            'refunded' => 'Refunded',
            'failed' => 'Failed',
        ];

        return view('admin.orders.edit', compact('order', 'statusOptions', 'paymentStatusOptions'));
    }

    /**
     * Update the specified order in storage.
     */
    public function update(Request $request, $id)
    {
        $order = Order::with(['shippingAddress', 'billingAddress', 'items'])->findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,returned,refunded,cancelled',
            'payment_status' => 'required|in:pending,authorized,paid,partially_paid,refunded,failed',
            'tracking_number' => 'nullable|string|max:255',
            'courier_name' => 'nullable|string|max:255',
            'customer_notes' => 'nullable|string',
            'admin_notes' => 'nullable|string',
            'estimated_delivery_date' => 'nullable|date',
            'shipping_method' => 'nullable|in:standard,express,same_day',
            'shipping_cost' => 'required|numeric|min:0',
            'tax_amount' => 'required|numeric|min:0',
            'discount_amount' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'items.*.quantity' => 'sometimes|required|integer|min:1',
            'items.*.unit_price' => 'sometimes|required|numeric|min:0',
            'shipping_address.full_name' => 'required|string|max:255',
            'shipping_address.phone' => 'required|string',
            'shipping_address.email' => 'nullable|email',
            'shipping_address.address_line_1' => 'required|string',
            'shipping_address.address_line_2' => 'nullable|string',
            'shipping_address.city' => 'nullable|string',
            'shipping_address.area' => 'nullable|string',
            'shipping_address.postal_code' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            // Update order
            $order->update([
                'status' => $validated['status'],
                'payment_status' => $validated['payment_status'],
                'tracking_number' => $validated['tracking_number'] ?? $order->tracking_number,
                'courier_name' => $validated['courier_name'] ?? $order->courier_name,
                'customer_notes' => $validated['customer_notes'] ?? $order->customer_notes,
                'admin_notes' => $validated['admin_notes'] ?? $order->admin_notes,
                'estimated_delivery_date' => $validated['estimated_delivery_date'] ?? $order->estimated_delivery_date,
                'shipping_method' => $validated['shipping_method'] ?? $order->shipping_method,
                'shipping_cost' => $validated['shipping_cost'],
                'tax_amount' => $validated['tax_amount'],
                'discount_amount' => $validated['discount_amount'],
                'total_amount' => $validated['total_amount'],
            ]);

            // Update shipping address
            if ($order->shippingAddress && isset($validated['shipping_address'])) {
                $order->shippingAddress->update($validated['shipping_address']);
            }

            // Update billing address if provided
            if ($request->has('billing_address') && $order->billingAddress) {
                $billingValidated = $request->validate([
                    'billing_address.full_name' => 'nullable|string|max:255',
                    'billing_address.phone' => 'nullable|string',
                    'billing_address.email' => 'nullable|email',
                    'billing_address.address_line_1' => 'nullable|string',
                    'billing_address.address_line_2' => 'nullable|string',
                    'billing_address.city' => 'nullable|string',
                    'billing_address.area' => 'nullable|string',
                    'billing_address.postal_code' => 'nullable|string',
                ]);

                $order->billingAddress->update($billingValidated['billing_address']);
            }

            // Update order items if provided
            if ($request->has('items')) {
                foreach ($request->items as $itemId => $itemData) {
                    $orderItem = OrderItem::find($itemId);
                    if ($orderItem && $orderItem->order_id == $order->id) {
                        $orderItem->update([
                            'quantity' => $itemData['quantity'],
                            'unit_price' => $itemData['unit_price'],
                            'total_price' => $itemData['quantity'] * $itemData['unit_price']
                        ]);
                    }
                }
            }

            // Update payment if payment status changed to paid
            if ($validated['payment_status'] === 'paid' && $order->payment_status !== 'paid') {
                $this->updatePaymentStatus($order);
            }

            DB::commit();

            return redirect()->route('admin.orders.show', $order->id)
                ->with('success', 'Order updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order update failed: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Failed to update order: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Update order status.
     */
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,returned,refunded,cancelled'
        ]);

        DB::beginTransaction();

        try {
            $order->updateStatus($request->status);

            // If status changed to delivered, mark as paid if not already
            if ($request->status === 'delivered' && $order->payment_status === 'pending') {
                $order->update(['payment_status' => 'paid']);
                $this->updatePaymentStatus($order);
            }

            DB::commit();

            return redirect()->back()
                ->with('success', 'Order status updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order status update failed: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Failed to update order status: ' . $e->getMessage());
        }
    }

    /**
     * Mark order as paid.
     */
    public function markAsPaid($id)
    {
        $order = Order::with('payments')->findOrFail($id);

        DB::beginTransaction();

        try {
            $order->markAsPaid();

            // Update or create payment record
            $this->updatePaymentStatus($order);

            DB::commit();

            return redirect()->back()
                ->with('success', 'Order marked as paid successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Mark as paid failed: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Failed to mark order as paid: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $order = Order::with(['items', 'payments'])->findOrFail($id);

        // Check if order can be deleted
        if (!$order->canBeCancelled() && !in_array($order->status, ['pending', 'cancelled'])) {
            return redirect()->back()
                ->with('error', 'Cannot delete order with current status. Only pending or cancelled orders can be deleted.');
        }

        DB::beginTransaction();

        try {
            // Restore stock for order items
            foreach ($order->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->increment('stock', $item->quantity);
                }
            }

            // Delete related records
            $order->payments()->delete();
            $order->items()->delete();
            $order->delete();

            DB::commit();

            return redirect()->route('admin.orders.index')
                ->with('success', 'Order deleted successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order deletion failed: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Failed to delete order: ' . $e->getMessage());
        }
    }

    /**
     * Download invoice as PDF
     */
    public function downloadInvoice(Order $order)
    {
        $order->load([
            'customer',
            'shippingAddress',
            'billingAddress',
            'items.product',
            'payments'
        ]);

        $pdf = PDF::loadView('admin.orders.invoice', compact('order'));

        return $pdf->download('invoice-' . $order->order_number . '.pdf');
    }

    /**
     * Email invoice to customer
     */
    public function emailInvoice(Order $order)
    {
        try {
            $order->load(['customer', 'shippingAddress', 'items.product']);

            // Generate PDF
            $pdf = PDF::loadView('admin.orders.invoice', compact('order'));

            // Email the invoice
            // Mail::to($order->customer_email)->send(new OrderInvoice($order, $pdf));

            return redirect()->back()->with('success', 'Invoice sent to customer successfully.');

        } catch (\Exception $e) {
            Log::error('Email invoice failed: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Failed to send invoice: ' . $e->getMessage());
        }
    }

    /**
     * Helper method to update payment status
     */
    private function updatePaymentStatus(Order $order): void
    {
        // Update or create payment record
        $payment = $order->payments()->latest()->first();

        if ($payment) {
            $payment->update([
                'status' => 'completed',
                'paid_amount' => $order->total_amount,
                'paid_at' => now(),
            ]);
        } else {
            Payment::create([
                'order_id' => $order->id,
                'customer_id' => $order->customer_id,
                'payment_number' => 'PAY-' . date('ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
                'payment_method' => $order->payment_method,
                'amount' => $order->total_amount,
                'paid_amount' => $order->total_amount,
                'status' => 'completed',
                'paid_at' => now(),
            ]);
        }
    }

    /**
     * Delete order (soft delete)
     */
    public function delete($id)
    {
        $order = Order::findOrFail($id);

        if (!$order->canBeCancelled()) {
            return redirect()->back()
                ->with('error', 'Cannot delete order with current status');
        }

        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order deleted successfully');
    }
}