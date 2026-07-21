<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class LicenseService
{
    protected $apiUrl;
    protected $licenseKey;
    protected $cacheDuration;

    public function __construct()
    {
        setLicenseConfigFromDB();
        $this->apiUrl = config('license.api_url');
        $this->licenseKey = config('license.license_key');
        $this->cacheDuration = config('license.cache.duration', 6);
    }

    /**
     * Verify license status
     */
    public function verify($forceRefresh = false)
    {
        $cacheKey = config('license.cache.key');

        // Return cached data if not forcing refresh
        if (!$forceRefresh && Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            $response = Http::timeout(3)
                ->retry(1, 100)
                ->post($this->apiUrl . '/clients/verify-by-license', [
                    'license_key' => $this->licenseKey
                ]);

            if ($response->successful()) {
                $data = $response->json();

                // Ensure all required keys exist with defaults
                $data = array_merge([
                    'valid' => false,
                    'is_expired' => false,
                    'status' => 'unknown',
                    'client' => [],
                    'product' => [],
                    'expires_in_days' => 0,
                    'expires_at_human' => '',
                ], $data);

                // Enhance with additional calculations
                $data['verified_at'] = now()->toISOString();
                $data['is_in_grace_period'] = $this->isInGracePeriod($data);
                $data['days_until_expiry'] = $this->getDaysUntilExpiry($data);
                $data['status_level'] = $this->getStatusLevel($data);
                $data['api_unreachable'] = false;

                // Cache the response
                Cache::put($cacheKey, $data, now()->addHours($this->cacheDuration));

                return $data;
            }

            // Handle 404 - License key not found
            if ($response->status() === 404) {
                $errorData = $response->json();
                Log::warning('License key not found', [
                    'license_key' => $this->licenseKey,
                    'message' => $errorData['message'] ?? 'License key not found'
                ]);

                return $this->getLicenseNotFoundData($errorData['message'] ?? 'License key not found');
            }

            Log::warning('License API returned error', ['status' => $response->status()]);
            return $this->getFallbackData('API returned status: ' . $response->status());

        } catch (\Exception $e) {
            Log::error('License verification failed', ['error' => $e->getMessage()]);
            return $this->getFallbackData($e->getMessage());
        }
    }

    /**
     * Get data for when license key is not found
     */
    private function getLicenseNotFoundData($message = 'License key not found')
    {
        // Clear any cached data since license key is invalid
        Cache::forget(config('license.cache.key'));

        return [
            'valid' => false,
            'is_expired' => false,
            'status' => 'not_found',
            'client' => [],
            'product' => [],
            'expires_in_days' => 0,
            'expires_at_human' => '',
            'is_in_grace_period' => false,
            'days_until_expiry' => 0,
            'status_level' => 'not_found',
            'verified_at' => now()->toISOString(),
            'api_unreachable' => false,
            'license_not_found' => true,
            'message' => $message,
        ];
    }

    /**
     * Fallback data when API fails or is unreachable
     */
    private function getFallbackData($error = '')
    {
        $cacheKey = config('license.cache.key');
        $cached = Cache::get($cacheKey);

        if ($cached) {
            $cached['api_unreachable'] = true;
            $cached['last_verified'] = $cached['verified_at'] ?? null;
            $cached['error'] = $error;

            // Re-cache for 15 minutes to avoid hammering a down API server
            Cache::put($cacheKey, $cached, now()->addMinutes(15));
            return $cached;
        }

        // Default structure when API is unreachable and no previous cache exists:
        // Treat as valid with api_unreachable flag so site runs normally
        $fallback = [
            'valid' => true,
            'is_expired' => false,
            'status' => 'active',
            'client' => [],
            'product' => [],
            'expires_in_days' => 365,
            'expires_at_human' => 'Unknown (Offline)',
            'is_in_grace_period' => false,
            'days_until_expiry' => 365,
            'status_level' => 'success',
            'verified_at' => now()->toISOString(),
            'api_unreachable' => true,
            'message' => 'License API unreachable, running in offline fallback mode: ' . $error,
        ];

        // Cache fallback for 15 minutes
        Cache::put($cacheKey, $fallback, now()->addMinutes(15));

        return $fallback;
    }

    /**
     * Check if license is valid
     */
    public function isValid()
    {
        $status = $this->verify();

        if ($status['license_not_found'] ?? false) {
            return false;
        }

        if (!$status['valid'] && config('license.grace_period.enabled')) {
            return $status['is_in_grace_period'];
        }

        return $status['valid'];
    }

    /**
     * Get license status with details
     */
    public function getStatus()
    {
        return $this->verify();
    }

    /**
     * Force refresh license status
     */
    public function refresh()
    {
        return $this->verify(true);
    }

    /**
     * Check if in grace period
     */
    private function isInGracePeriod($data)
    {
        // If license is not found, no grace period
        if ($data['license_not_found'] ?? false) {
            return false;
        }

        // If license is valid, no grace period needed
        if ($data['valid'] ?? false) {
            return false;
        }

        // Check for blocked statuses - no grace period for these!
        $blockedStatuses = ['suspended', 'cancelled', 'revoked', 'terminated', 'not_found'];
        if (in_array($data['status'] ?? '', $blockedStatuses)) {
            return false;
        }

        // Check if grace period is enabled in config
        if (!config('license.grace_period.enabled', true)) {
            return false;
        }

        // Need to have an expiration date to calculate grace period
        if (!isset($data['client']['license_expires_at']) || empty($data['client']['license_expires_at'])) {
            return false;
        }

        // Only expired licenses get grace period
        if (!($data['is_expired'] ?? false)) {
            return false;
        }

        try {
            $expiryDate = Carbon::parse($data['client']['license_expires_at']);
            $gracePeriodDays = config('license.grace_period.days', 7);

            // Grace period = expiration date + grace period days
            $gracePeriodEnd = $expiryDate->copy()->addDays($gracePeriodDays);

            // Check if we're still within the grace period
            return $gracePeriodEnd->isFuture();

        } catch (\Exception $e) {
            Log::error('Error calculating grace period', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Get days until expiry
     */
    private function getDaysUntilExpiry($data)
    {
        if (!isset($data['client']['license_expires_at']) || empty($data['client']['license_expires_at'])) {
            return null;
        }

        try {
            $expiryDate = Carbon::parse($data['client']['license_expires_at']);
            return now()->diffInDays($expiryDate, false); // false = return negative if expired
        } catch (\Exception $e) {
            Log::error('Error calculating days until expiry', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Get status level for UI display
     */
    private function getStatusLevel($data)
    {
        if ($data['license_not_found'] ?? false) {
            return 'not_found';
        }

        if ($data['valid']) {
            $days = $this->getDaysUntilExpiry($data);

            if ($days <= 30 && $days > 7) {
                return 'warning';
            } elseif ($days <= 7 && $days > 0) {
                return 'danger';
            }
            return 'success';
        }

        if ($this->isInGracePeriod($data)) {
            return 'grace';
        }

        if (in_array($data['status'] ?? '', ['suspended', 'cancelled', 'revoked', 'terminated'])) {
            return 'blocked';
        }

        return 'expired';
    }

    /**
     * Clear license cache
     */
    public function clearCache()
    {
        Cache::forget(config('license.cache.key'));
        return true;
    }
}