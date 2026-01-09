<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('can:customers_manage')->only([
    //         'index',
    //         'show',
    //         'edit',
    //         'update',
    //         'destroy',
    //         'export',
    //         'sendEmail',
    //     ]);
    // }

    /**
     * Display a listing of customers.
     */
    public function index(Request $request)
    {
        $query = Customer::withCount(['orders', 'addresses']);

        // Search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Type filter
        if ($request->has('type') && !empty($request->type)) {
            $query->where('type', $request->type);
        }

        // Status filter
        if ($request->has('is_active') && $request->is_active !== '') {
            $query->where('is_active', $request->is_active);
        }

        // Date range filter
        if ($request->has('start_date') && !empty($request->start_date)) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && !empty($request->end_date)) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Sort options
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $customers = $query->paginate(20);

        // Statistics
        $totalCustomers = Customer::count();
        $registeredCustomers = Customer::where('type', 'registered')->count();
        $guestCustomers = Customer::where('type', 'guest')->count();
        $activeCustomers = Customer::where('is_active', true)->count();
        $inactiveCustomers = Customer::where('is_active', false)->count();

        // Top customers by orders
        $topCustomersByOrders = Customer::withCount('orders')
            ->orderBy('orders_count', 'desc')
            ->limit(5)
            ->get();

        // Top customers by spending
        $topCustomersBySpending = Customer::withSum('orders', 'total_amount')
            ->orderBy('orders_sum_total_amount', 'desc')
            ->limit(5)
            ->get();

        return view('admin.customers.index', compact(
            'customers',
            'totalCustomers',
            'registeredCustomers',
            'guestCustomers',
            'activeCustomers',
            'inactiveCustomers',
            'topCustomersByOrders',
            'topCustomersBySpending'
        ));
    }

    /**
     * Display the specified customer.
     */
    public function show(Customer $customer)
    {
        // Load customer with relationships
        $customer->load([
            'addresses',
            'orders' => function ($query) {
                $query->with(['items.product', 'shippingAddress'])
                    ->orderBy('created_at', 'desc');
            }
        ]);

        // Customer statistics
        $totalOrders = $customer->orders->count();
        $totalSpent = $customer->orders->sum('total_amount');
        $avgOrderValue = $totalOrders > 0 ? $totalSpent / $totalOrders : 0;

        // Order status counts
        $pendingOrders = $customer->orders->where('status', 'pending')->count();
        $processingOrders = $customer->orders->whereIn('status', ['confirmed', 'processing'])->count();
        $shippedOrders = $customer->orders->where('status', 'shipped')->count();
        $deliveredOrders = $customer->orders->where('status', 'delivered')->count();
        $cancelledOrders = $customer->orders->whereIn('status', ['cancelled', 'returned', 'refunded'])->count();

        // Get purchased products with details
        $purchasedProducts = $this->getPurchasedProducts($customer);

        // Get purchase categories
        $purchaseCategories = $this->getPurchaseCategories($customer);

        // Get purchase brands
        $purchaseBrands = $this->getPurchaseBrands($customer);

        // Get recent orders
        $recentOrders = $customer->orders()
            ->with(['items.product', 'shippingAddress'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get order history chart data
        $orderHistory = $this->getOrderHistory($customer);

        // Get lifetime value
        $lifetimeValue = $this->calculateLifetimeValue($customer);

        // Get customer segments
        $customerSegment = $this->getCustomerSegment($customer);

        return view('admin.customers.show', compact(
            'customer',
            'totalOrders',
            'totalSpent',
            'avgOrderValue',
            'pendingOrders',
            'processingOrders',
            'shippedOrders',
            'deliveredOrders',
            'cancelledOrders',
            'purchasedProducts',
            'purchaseCategories',
            'purchaseBrands',
            'recentOrders',
            'orderHistory',
            'lifetimeValue',
            'customerSegment'
        ));
    }

    /**
     * Show the form for editing the specified customer.
     */
    public function edit(Customer $customer)
    {
        $customer->load(['addresses']);

        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified customer in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:customers,email,' . $customer->id,
            'phone' => 'required|string|unique:customers,phone,' . $customer->id,
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'is_active' => 'boolean',
            'accepts_marketing' => 'boolean',
            'type' => 'required|in:guest,registered',
        ]);

        // Handle password update
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
            $validated['password'] = bcrypt($request->password);
        }

        $customer->update($validated);

        // Update addresses if provided
        if ($request->has('addresses')) {
            foreach ($request->addresses as $addressId => $addressData) {
                if ($address = $customer->addresses()->find($addressId)) {
                    $address->update($addressData);
                }
            }
        }

        // Add new address if provided
        if ($request->has('new_address')) {
            $customer->addresses()->create($request->new_address);
        }

        return redirect()->route('admin.customers.show', $customer->id)
            ->with('success', 'Customer updated successfully');
    }

    /**
     * Remove the specified customer from storage.
     */
    public function destroy(Customer $customer)
    {
        // Check if customer has orders
        if ($customer->orders()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete customer with existing orders. Please delete orders first.');
        }

        $customer->delete();

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer deleted successfully');
    }

    /**
     * Export customers to CSV/Excel
     */
    public function export(Request $request)
    {
        $query = Customer::withCount('orders')->withSum('orders', 'total_amount');

        if ($request->has('type') && !empty($request->type)) {
            $query->where('type', $request->type);
        }

        $customers = $query->get();

        // Generate CSV
        $fileName = 'customers-' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function () use ($customers) {
            $file = fopen('php://output', 'w');

            // Header row
            fputcsv($file, [
                'ID',
                'Full Name',
                'Email',
                'Phone',
                'Type',
                'Total Orders',
                'Total Spent',
                'Avg Order Value',
                'Last Order Date',
                'Created Date',
                'Status'
            ]);

            // Data rows
            foreach ($customers as $customer) {
                $lastOrder = $customer->orders()->latest()->first();

                fputcsv($file, [
                    $customer->id,
                    $customer->full_name,
                    $customer->email,
                    $customer->phone,
                    $customer->type,
                    $customer->orders_count,
                    $customer->orders_sum_total_amount ?? 0,
                    $customer->orders_count > 0 ? ($customer->orders_sum_total_amount / $customer->orders_count) : 0,
                    $lastOrder ? $lastOrder->created_at->format('Y-m-d') : 'N/A',
                    $customer->created_at->format('Y-m-d'),
                    $customer->is_active ? 'Active' : 'Inactive'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Send email to customer
     */
    public function sendEmail(Request $request, Customer $customer)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        try {
            // Send email logic here
            // Mail::to($customer->email)->send(new CustomerEmail($request->subject, $request->message));

            return redirect()->back()
                ->with('success', 'Email sent successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to send email: ' . $e->getMessage());
        }
    }

    /**
     * Get purchased products for a customer
     */
    private function getPurchasedProducts(Customer $customer)
    {
        return DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
            ->where('orders.customer_id', $customer->id)
            ->whereIn('orders.status', ['confirmed', 'processing', 'shipped', 'delivered'])
            ->select([
                'products.id',
                'products.name',
                'products.sku',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.total_price) as total_amount'),
                DB::raw('AVG(order_items.unit_price) as avg_price'),
                'categories.name as category_name',
                'brands.name as brand_name'
            ])
            ->groupBy('products.id', 'products.name', 'products.sku', 'categories.name', 'brands.name')
            ->orderBy('total_quantity', 'desc')
            ->get();
    }

    /**
     * Get purchase categories for a customer
     */
    private function getPurchaseCategories(Customer $customer)
    {
        return DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('orders.customer_id', $customer->id)
            ->whereIn('orders.status', ['confirmed', 'processing', 'shipped', 'delivered'])
            ->select([
                'categories.id',
                'categories.name',
                DB::raw('COUNT(DISTINCT orders.id) as order_count'),
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.total_price) as total_amount')
            ])
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total_amount', 'desc')
            ->get();
    }

    /**
     * Get purchase brands for a customer
     */
    private function getPurchaseBrands(Customer $customer)
    {
        return DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->where('orders.customer_id', $customer->id)
            ->whereIn('orders.status', ['confirmed', 'processing', 'shipped', 'delivered'])
            ->select([
                'brands.id',
                'brands.name',
                DB::raw('COUNT(DISTINCT orders.id) as order_count'),
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.total_price) as total_amount')
            ])
            ->groupBy('brands.id', 'brands.name')
            ->orderBy('total_amount', 'desc')
            ->get();
    }

    /**
     * Get order history for chart
     */
    private function getOrderHistory(Customer $customer)
    {
        $orders = $customer->orders()
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as order_count'),
                DB::raw('SUM(total_amount) as total_amount')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return $orders;
    }

    /**
     * Calculate customer lifetime value
     */
    private function calculateLifetimeValue(Customer $customer)
    {
        $orders = $customer->orders()
            ->whereIn('status', ['delivered'])
            ->orderBy('created_at')
            ->get();

        $totalSpent = $orders->sum('total_amount');
        $orderCount = $orders->count();

        // Get first and last order dates
        $firstOrder = $orders->first();
        $lastOrder = $orders->last();

        $firstOrderDate = $firstOrder ? $firstOrder->created_at : null;
        $lastOrderDate = $lastOrder ? $lastOrder->created_at : null;

        if ($firstOrderDate && $lastOrderDate) {
            $daysActive = $firstOrderDate->diffInDays($lastOrderDate);
            $avgDaysBetweenOrders = $orderCount > 1 ? $daysActive / ($orderCount - 1) : 0;
        } else {
            $daysActive = 0;
            $avgDaysBetweenOrders = 0;
        }

        $avgOrderValue = $orderCount > 0 ? $totalSpent / $orderCount : 0;
        $predictedOrdersPerYear = $avgDaysBetweenOrders > 0 ? 365 / $avgDaysBetweenOrders : 0;
        $predictedLTV = $predictedOrdersPerYear * $avgOrderValue * 3; // Assuming 3 year retention

        return [
            'total_spent' => $totalSpent,
            'order_count' => $orderCount,
            'avg_order_value' => $avgOrderValue,
            'first_order_date' => $firstOrderDate,
            'last_order_date' => $lastOrderDate,
            'days_active' => $daysActive,
            'avg_days_between_orders' => round($avgDaysBetweenOrders, 1),
            'predicted_orders_per_year' => round($predictedOrdersPerYear, 1),
            'predicted_ltv' => round($predictedLTV, 2),
        ];
    }

    /**
     * Get customer segment
     */
    private function getCustomerSegment(Customer $customer)
    {
        $totalSpent = $customer->orders()->where('status', 'delivered')->sum('total_amount');
        $orderCount = $customer->orders()->count();

        // Get first order properly
        $firstOrder = $customer->orders()->orderBy('created_at')->first();
        $daysSinceFirstOrder = $firstOrder ? $firstOrder->created_at->diffInDays(now()) : 0;

        if ($orderCount === 0) {
            return 'New';
        } elseif ($orderCount === 1) {
            return 'One-time';
        } elseif ($orderCount <= 3) {
            return 'Occasional';
        } elseif ($totalSpent < 5000) {
            return 'Regular';
        } elseif ($totalSpent < 20000) {
            return 'Loyal';
        } else {
            return 'VIP';
        }
    }

    /**
     * Get customer activity log
     */
    public function activity(Customer $customer)
    {
        // Combine orders, reviews, wishlist activities, etc.
        $activities = collect();

        // Add orders
        $customer->orders()->with(['items.product'])->latest()->each(function ($order) use ($activities) {
            $activities->push([
                'type' => 'order',
                'icon' => 'shopping-cart',
                'title' => 'Placed Order #' . $order->order_number,
                'description' => 'Order total: ৳' . number_format($order->total_amount, 2),
                'date' => $order->created_at,
                'data' => $order
            ]);
        });

        // Sort by date
        $activities = $activities->sortByDesc('date');

        return view('admin.customers.activity', compact('customer', 'activities'));
    }

    /**
     * Get customer's abandoned carts
     */
    public function abandonedCarts(Customer $customer)
    {
        $abandonedCarts = \App\Models\ShoppingCart::where('customer_id', $customer->id)
            ->orWhere('customer_email', $customer->email)
            ->orWhere('customer_phone', $customer->phone)
            ->with(['items.product'])
            ->whereHas('items')
            ->whereDoesntHave('items', function ($query) {
                $query->whereHas('orderItem');
            })
            ->get();

        return view('admin.customers.abandoned-carts', compact('customer', 'abandonedCarts'));
    }

    /**
     * Get customer's wishlist
     */
    public function wishlist(Customer $customer)
    {
        // If you have a wishlist system
        // $wishlist = $customer->wishlist()->with('product')->get();

        return view('admin.customers.wishlist', compact('customer'/*, 'wishlist'*/));
    }

    /**
     * Toggle customer status
     */
    public function toggleStatus(Customer $customer)
    {
        $customer->update(['is_active' => !$customer->is_active]);

        return redirect()->back()
            ->with('success', 'Customer status updated successfully');
    }

    /**
     * Merge duplicate customers
     */
    public function merge(Request $request)
    {
        $request->validate([
            'primary_customer_id' => 'required|exists:customers,id',
            'duplicate_customer_ids' => 'required|array',
            'duplicate_customer_ids.*' => 'exists:customers,id',
        ]);

        DB::beginTransaction();

        try {
            $primaryCustomer = Customer::find($request->primary_customer_id);
            $duplicateCustomers = Customer::whereIn('id', $request->duplicate_customer_ids)->get();

            foreach ($duplicateCustomers as $duplicate) {
                // Update orders
                Order::where('customer_id', $duplicate->id)
                    ->update(['customer_id' => $primaryCustomer->id]);

                // Update addresses
                \App\Models\CustomerAddress::where('customer_id', $duplicate->id)
                    ->update(['customer_id' => $primaryCustomer->id]);

                // Update other references as needed

                // Delete duplicate customer
                $duplicate->delete();
            }

            DB::commit();

            return redirect()->route('admin.customers.show', $primaryCustomer->id)
                ->with('success', 'Customers merged successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to merge customers: ' . $e->getMessage());
        }
    }
}