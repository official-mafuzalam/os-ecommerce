<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\LicenseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class LicenseController extends Controller
{
    protected $licenseService;

    public function __construct(LicenseService $licenseService)
    {
        $this->licenseService = $licenseService;
    }

    /**
     * Show admin panel license & subscription management view page
     */
    public function index(Request $request)
    {
        $status = $request->session()->get('license_status', $this->licenseService->getStatus());

        $status = array_merge([
            'valid' => false,
            'is_expired' => false,
            'status' => 'unknown',
            'client' => [],
            'product' => [],
            'expires_in_days' => 0,
            'expires_at_human' => '',
            'is_in_grace_period' => false,
            'days_until_expiry' => 0,
            'status_level' => 'unknown',
            'verified_at' => null,
            'api_unreachable' => false,
            'message' => '',
        ], $status);

        $isInGracePeriod = $status['is_in_grace_period'] ?? false;
        $gracePeriodInfo = [];

        $expiryStr = $status['subscription']['expires_at'] ?? $status['client']['license_expires_at'] ?? null;

        if ($isInGracePeriod && $expiryStr) {
            $gracePeriodDays = config('license.grace_period.days', 7);
            $daysExpired = abs($status['days_until_expiry'] ?? 0);
            $daysRemaining = max(0, $gracePeriodDays - $daysExpired);
            $gracePeriodEnd = Carbon::parse($expiryStr)->addDays($gracePeriodDays);

            $gracePeriodInfo = [
                'days_remaining' => $daysRemaining,
                'ends_at' => $gracePeriodEnd,
                'total_days' => $gracePeriodDays,
            ];
        }

        return view('admin.license.index', [
            'status' => $status,
            'isInGracePeriod' => $isInGracePeriod,
            'gracePeriodInfo' => $gracePeriodInfo,
            'success' => $request->session()->get('success'),
            'error' => $request->session()->get('error'),
        ]);
    }

    /**
     * Show standalone public license warning page
     */
    public function warning(Request $request)
    {
        $status = $request->session()->get('license_status', $this->licenseService->getStatus());

        $status = array_merge([
            'valid' => false,
            'is_expired' => false,
            'status' => 'unknown',
            'client' => [],
            'product' => [],
            'expires_in_days' => 0,
            'expires_at_human' => '',
            'is_in_grace_period' => false,
            'days_until_expiry' => 0,
            'status_level' => 'unknown',
            'verified_at' => null,
            'api_unreachable' => false,
            'message' => '',
        ], $status);

        $isInGracePeriod = $status['is_in_grace_period'] ?? false;
        $gracePeriodInfo = [];

        $expiryStr = $status['subscription']['expires_at'] ?? $status['client']['license_expires_at'] ?? null;

        if ($isInGracePeriod && $expiryStr) {
            $gracePeriodDays = config('license.grace_period.days', 7);
            $daysExpired = abs($status['days_until_expiry'] ?? 0);
            $daysRemaining = max(0, $gracePeriodDays - $daysExpired);
            $gracePeriodEnd = Carbon::parse($expiryStr)->addDays($gracePeriodDays);

            $gracePeriodInfo = [
                'days_remaining' => $daysRemaining,
                'ends_at' => $gracePeriodEnd,
                'total_days' => $gracePeriodDays,
            ];
        }

        return view('public.license.warning', [
            'status' => $status,
            'isInGracePeriod' => $isInGracePeriod,
            'gracePeriodInfo' => $gracePeriodInfo,
            'success' => $request->session()->get('success'),
            'error' => $request->session()->get('error'),
        ]);
    }

    /**
     * Refresh license & subscription status
     */
    public function refresh(Request $request)
    {
        try {
            $status = $this->licenseService->refresh();
            $request->session()->flash('license_status', $status);

            if ($status['valid'] || ($status['is_in_grace_period'] ?? false)) {
                return redirect()->back()
                    ->with('success', 'License status refreshed successfully!')
                    ->with('license_status', $status);
            }

            return redirect()->back()
                ->with('error', 'License is invalid or expired.')
                ->with('license_status', $status);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to refresh license: ' . $e->getMessage());
        }
    }

    /**
     * Update license key
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'license_key' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $this->updateLicenseKey($request->license_key);
            $status = $this->licenseService->refresh();

            return redirect()->back()
                ->with('success', 'License key updated successfully!')
                ->with('license_status', $status);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update license key: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Get license status (JSON API)
     */
    public function status(Request $request)
    {
        $status = $this->licenseService->getStatus();

        return response()->json([
            'success' => true,
            'data' => $status,
            'timestamp' => now()->toISOString(),
        ]);
    }

    /**
     * Fetch Client Invoices (JSON API)
     */
    public function invoices(Request $request)
    {
        $statusFilter = $request->query('status', 'all');
        $invoicesData = $this->licenseService->getInvoices($statusFilter);

        return response()->json($invoicesData);
    }

    /**
     * Fetch Single Invoice Detail (JSON API)
     */
    public function invoiceDetail(Request $request, $invoiceNumber)
    {
        $invoiceData = $this->licenseService->getInvoiceDetails($invoiceNumber);

        return response()->json($invoiceData);
    }

    /**
     * Submit Manual Payment Transaction proof
     */
    public function submitPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0.01',
            'transaction_id' => 'required|string|max:100',
            'payment_method' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:500',
            'screenshot' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $isJsonRequest = $request->wantsJson() || $request->expectsJson() || $request->ajax();

        if ($validator->fails()) {
            if ($isJsonRequest) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors()
                ], 422);
            }

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $paymentData = [
            'amount' => $request->input('amount'),
            'transaction_id' => trim($request->input('transaction_id')),
            'payment_method' => $request->input('payment_method', 'Manual Payment'),
            'notes' => $request->input('notes', ''),
        ];

        $screenshotFile = $request->file('screenshot');
        $result = $this->licenseService->submitPaymentTransaction($paymentData, $screenshotFile);

        if ($isJsonRequest) {
            return response()->json($result);
        }

        if ($result['success'] ?? false) {
            return redirect()->back()
                ->with('success', $result['message'] ?? 'Payment submission received successfully! We will review it shortly.');
        }

        return redirect()->back()
            ->with('error', $result['message'] ?? 'Payment submission failed.')
            ->withInput();
    }

    /**
     * Check Submission Review Status
     */
    public function checkSubmissionStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transaction_id' => 'required|string|max:100',
        ]);

        $isJsonRequest = $request->wantsJson() || $request->expectsJson() || $request->ajax();

        if ($validator->fails()) {
            if ($isJsonRequest) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors()
                ], 422);
            }

            return redirect()->back()
                ->withErrors($validator);
        }

        $transactionId = trim($request->input('transaction_id'));
        $result = $this->licenseService->checkPaymentSubmissionStatus($transactionId);

        if ($isJsonRequest) {
            return response()->json($result);
        }

        if ($result['found'] ?? false) {
            return redirect()->back()
                ->with('success', "Submission status for {$transactionId}: " . strtoupper($result['status'] ?? 'unknown') . ". " . ($result['message'] ?? ''));
        }

        return redirect()->back()
            ->with('error', $result['message'] ?? 'No submission found for transaction ID: ' . $transactionId);
    }

    /**
     * Update license key in configuration
     */
    private function updateLicenseKey($newKey)
    {
        $newKey = trim($newKey);

        // 1. Update DB setting if setting model exists
        if (class_exists('\App\Models\Setting')) {
            try {
                \App\Models\Setting::updateOrCreate(
                    ['key' => 'license_key'],
                    ['value' => $newKey, 'type' => 'text', 'group' => 'license', 'label' => 'License Key']
                );
                \Illuminate\Support\Facades\Cache::forget('setting_license_key');
            } catch (\Exception $e) {
                // Ignore DB error if table not present
            }
        }

        // 2. Set runtime config immediately for current request
        config(['license.license_key' => $newKey]);

        // 3. Defer .env update to shutdown function to prevent php artisan serve from resetting connection mid-request
        register_shutdown_function(function () use ($newKey) {
            try {
                $envPath = base_path('.env');
                if (file_exists($envPath)) {
                    $envContent = file_get_contents($envPath);
                    if (strpos($envContent, 'LICENSE_KEY=') !== false) {
                        $envContent = preg_replace(
                            '/LICENSE_KEY=.*/',
                            'LICENSE_KEY=' . $newKey,
                            $envContent
                        );
                    } else {
                        $envContent .= "\nLICENSE_KEY=" . $newKey;
                    }
                    file_put_contents($envPath, $envContent);
                }
            } catch (\Exception $e) {
                // Ignore shutdown write errors
            }
        });

        return true;
    }
}