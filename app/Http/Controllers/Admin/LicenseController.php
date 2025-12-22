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
     * Show license warning page
     */
    public function warning(Request $request)
    {
        // Get license status from session or fresh check
        $status = $request->session()->get('license_status', $this->licenseService->getStatus());

        // Ensure all required keys exist with defaults
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

        // Calculate grace period details
        $isInGracePeriod = $status['is_in_grace_period'] ?? false;
        $gracePeriodInfo = [];

        if ($isInGracePeriod && isset($status['client']['license_expires_at'])) {
            $gracePeriodDays = config('license.grace_period.days', 7);
            $daysExpired = abs($status['days_until_expiry'] ?? 0);
            $daysRemaining = max(0, $gracePeriodDays - $daysExpired);
            $gracePeriodEnd = Carbon::parse($status['client']['license_expires_at'])->addDays($gracePeriodDays);

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
     * Refresh license status
     */
    public function refresh(Request $request)
    {
        try {
            // Force refresh license status
            $status = $this->licenseService->refresh();

            // Store in session for the warning page
            $request->session()->flash('license_status', $status);

            if ($status['valid'] || ($status['is_in_grace_period'] ?? false)) {
                return redirect()->route('license.warning')
                    ->with('success', 'License status refreshed successfully!')
                    ->with('license_status', $status);
            }

            return redirect()->route('license.warning')
                ->with('error', 'License is invalid or expired.')
                ->with('license_status', $status);

        } catch (\Exception $e) {
            return redirect()->route('license.warning')
                ->with('error', 'Failed to refresh license: ' . $e->getMessage());
        }
    }

    /**
     * Update license key
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'license_key' => 'required|string|size:36',
        ]);

        if ($validator->fails()) {
            return redirect()->route('license.warning')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Update .env file or configuration
            $this->updateLicenseKey($request->license_key);

            // Refresh license status
            $status = $this->licenseService->refresh();

            return redirect()->route('license.warning')
                ->with('success', 'License key updated successfully!')
                ->with('license_status', $status);

        } catch (\Exception $e) {
            return redirect()->route('license.warning')
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
     * Update license key in configuration
     */
    private function updateLicenseKey($newKey)
    {
        // Method 1: Update .env file (simplified - use with caution)
        $envPath = base_path('.env');

        if (file_exists($envPath)) {
            $envContent = file_get_contents($envPath);

            // Replace LICENSE_KEY value
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

        // Method 2: Update config cache (temporary for current request)
        config(['license.license_key' => $newKey]);

        // Method 3: Store in database (recommended for production)
        // \App\Models\Setting::updateOrCreate(
        //     ['key' => 'license_key'],
        //     ['value' => $newKey]
        // );

        return true;
    }
}