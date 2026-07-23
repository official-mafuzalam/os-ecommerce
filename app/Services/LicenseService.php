<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class LicenseService
{
    protected $apiUrl;
    protected $licenseKey;
    protected $cacheDuration;
    protected ApiService $apiService;

    public function __construct(?ApiService $apiService = null)
    {
        setLicenseConfigFromDB();
        $this->apiUrl = config('license.api_url');
        $this->licenseKey = config('license.license_key');
        $this->cacheDuration = config('license.cache.duration', 6);
        $this->apiService = $apiService ?? new ApiService($this->apiUrl);
    }

    /**
     * Verify license & subscription status via API
     */
    public function verify($forceRefresh = false, string $endpoint = '/clients/check-subscription')
    {
        setLicenseConfigFromDB();
        $this->licenseKey = config('license.license_key');
        $this->apiUrl = config('license.api_url');
        $this->apiService->setBaseUrl($this->apiUrl);

        $cacheKey = config('license.cache.key');

        // Return cached data if not forcing refresh
        if (!$forceRefresh && Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            $response = $this->apiService->post($endpoint, [
                'license_key' => $this->licenseKey
            ], [], 5, 1);

            if ($response->successful()) {
                $data = $response->json();

                $normalized = $this->normalizeResponseData($data);

                // Cache the response
                Cache::put($cacheKey, $normalized, now()->addHours($this->cacheDuration));

                return $normalized;
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
     * Check subscription status (Explicit call to /clients/check-subscription)
     */
    public function checkSubscription($forceRefresh = false)
    {
        return $this->verify($forceRefresh, '/clients/check-subscription');
    }

    /**
     * Fetch list of client invoices from OctoSync API
     */
    public function getInvoices(string $status = 'all')
    {
        setLicenseConfigFromDB();
        $licenseKey = config('license.license_key');

        try {
            $response = $this->apiService->getInvoices($licenseKey, $status);

            if ($response->successful()) {
                return $response->json();
            }

            return [
                'status' => 'error',
                'message' => 'Failed to fetch invoices: ' . ($response->json()['message'] ?? 'HTTP status ' . $response->status()),
                'invoices' => []
            ];
        } catch (\Exception $e) {
            Log::error('Fetch invoices failed', ['error' => $e->getMessage()]);
            return [
                'status' => 'error',
                'message' => 'Unable to connect to invoice service: ' . $e->getMessage(),
                'invoices' => []
            ];
        }
    }

    /**
     * Fetch details of a single invoice
     */
    public function getInvoiceDetails(string $invoiceNumber)
    {
        setLicenseConfigFromDB();
        $licenseKey = config('license.license_key');

        try {
            $response = $this->apiService->getInvoiceDetails($invoiceNumber, $licenseKey);

            if ($response->successful()) {
                return $response->json();
            }

            return [
                'status' => 'error',
                'message' => 'Invoice not found or invalid: ' . ($response->json()['message'] ?? 'HTTP status ' . $response->status())
            ];
        } catch (\Exception $e) {
            Log::error('Fetch invoice details failed', ['error' => $e->getMessage()]);
            return [
                'status' => 'error',
                'message' => 'Unable to connect to invoice detail service: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Submit a manual payment transaction
     */
    public function submitPaymentTransaction(array $paymentData, $screenshotFile = null)
    {
        setLicenseConfigFromDB();
        $licenseKey = config('license.license_key');

        $payload = array_merge([
            'license_key' => $licenseKey,
            'app_url' => url('/'),
            'amount' => $paymentData['amount'] ?? 0,
            'transaction_id' => $paymentData['transaction_id'] ?? '',
            'payment_method' => $paymentData['payment_method'] ?? 'manual',
            'notes' => $paymentData['notes'] ?? '',
        ], $paymentData);

        try {
            $response = $this->apiService->submitTransaction($payload, $screenshotFile);

            if ($response->successful()) {
                return array_merge([
                    'success' => true,
                    'message' => 'Transaction submitted successfully.'
                ], $response->json() ?? []);
            }

            $errorMsg = $response->json()['message'] ?? 'Submission failed with status code ' . $response->status();
            return [
                'success' => false,
                'message' => $errorMsg,
                'errors' => $response->json()['errors'] ?? []
            ];
        } catch (\Exception $e) {
            Log::error('Submit payment transaction failed', ['error' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Failed to submit payment transaction: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Check review status of a submitted transaction
     */
    public function checkPaymentSubmissionStatus(string $transactionId)
    {
        setLicenseConfigFromDB();
        $licenseKey = config('license.license_key');

        try {
            $response = $this->apiService->checkSubmissionStatus($licenseKey, $transactionId);

            if ($response->successful()) {
                return array_merge([
                    'success' => true
                ], $response->json() ?? []);
            }

            return [
                'success' => false,
                'found' => false,
                'message' => $response->json()['message'] ?? 'Transaction status check failed.'
            ];
        } catch (\Exception $e) {
            Log::error('Check payment submission status failed', ['error' => $e->getMessage()]);
            return [
                'success' => false,
                'found' => false,
                'message' => 'Failed to check submission status: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Normalize raw API response into standard structure
     */
    protected function normalizeResponseData(array $data): array
    {
        $subscription = $data['subscription'] ?? [];
        $client = $data['client'] ?? [];
        $product = $data['product'] ?? [];

        $status = $subscription['status'] ?? $data['status'] ?? 'unknown';
        $isExpired = $subscription['is_expired'] ?? $data['is_expired'] ?? false;
        $expiresAt = $subscription['expires_at'] ?? $client['license_expires_at'] ?? null;
        $daysUntilExpiry = $subscription['days_until_expiry'] ?? $data['days_until_expiry'] ?? $data['expires_in_days'] ?? null;
        $expiresAtHuman = $subscription['expires_at_human'] ?? $data['expires_at_human'] ?? '';

        if ($daysUntilExpiry === null && $expiresAt) {
            try {
                $daysUntilExpiry = (int) now()->diffInDays(Carbon::parse($expiresAt), false);
            } catch (\Exception $e) {
                $daysUntilExpiry = 0;
            }
        }

        // Map backwards-compatible fields on client array if not present
        if (!isset($client['license_expires_at'])) {
            $client['license_expires_at'] = $expiresAt;
        }
        if (!isset($client['license_type'])) {
            $client['license_type'] = $subscription['license_type'] ?? 'commercial';
        }

        // Ensure all required keys exist with defaults
        $normalized = array_merge([
            'valid' => false,
            'action' => 'block',
            'message' => '',
            'status' => $status,
            'is_expired' => $isExpired,
            'subscription' => array_merge([
                'status' => $status,
                'type' => 'yearly',
                'is_lifetime' => false,
                'license_type' => 'commercial',
                'expires_at' => $expiresAt,
                'expires_at_human' => $expiresAtHuman,
                'days_until_expiry' => $daysUntilExpiry ?? 0,
                'is_expired' => $isExpired,
                'auto_renew' => false,
            ], $subscription),
            'client' => $client,
            'product' => $product,
            'pending_invoice' => $data['pending_invoice'] ?? null,
            'checked_at' => $data['checked_at'] ?? now()->toISOString(),
            'expires_in_days' => $daysUntilExpiry ?? 0,
            'expires_at_human' => $expiresAtHuman,
            'days_until_expiry' => $daysUntilExpiry ?? 0,
        ], $data);

        $normalized['client'] = $client;
        $normalized['verified_at'] = now()->toISOString();
        $normalized['is_in_grace_period'] = $this->isInGracePeriod($normalized);
        $normalized['days_until_expiry'] = $this->getDaysUntilExpiry($normalized);
        $normalized['status_level'] = $this->getStatusLevel($normalized);
        $normalized['api_unreachable'] = false;
        $normalized['license_not_found'] = false;

        return $normalized;
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
            'action' => 'block',
            'message' => $message,
            'status' => 'not_found',
            'is_expired' => false,
            'subscription' => [
                'status' => 'not_found',
                'type' => 'unknown',
                'is_lifetime' => false,
                'license_type' => 'unknown',
                'expires_at' => null,
                'expires_at_human' => '',
                'days_until_expiry' => 0,
                'is_expired' => false,
                'auto_renew' => false,
            ],
            'client' => [],
            'product' => [],
            'pending_invoice' => null,
            'expires_in_days' => 0,
            'expires_at_human' => '',
            'is_in_grace_period' => false,
            'days_until_expiry' => 0,
            'status_level' => 'not_found',
            'verified_at' => now()->toISOString(),
            'checked_at' => now()->toISOString(),
            'api_unreachable' => false,
            'license_not_found' => true,
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
            'action' => 'allow',
            'message' => 'License API unreachable, running in offline fallback mode: ' . $error,
            'status' => 'active',
            'is_expired' => false,
            'subscription' => [
                'status' => 'active',
                'type' => 'offline',
                'is_lifetime' => true,
                'license_type' => 'commercial',
                'expires_at' => null,
                'expires_at_human' => 'Unknown (Offline)',
                'days_until_expiry' => 365,
                'is_expired' => false,
                'auto_renew' => false,
            ],
            'client' => [
                'company_name' => 'Offline Client',
                'company_email' => '',
                'license_type' => 'commercial',
                'license_expires_at' => null,
            ],
            'product' => [
                'name' => 'E-commerce System',
                'version' => 'v1.0',
            ],
            'pending_invoice' => null,
            'expires_in_days' => 365,
            'expires_at_human' => 'Unknown (Offline)',
            'is_in_grace_period' => false,
            'days_until_expiry' => 365,
            'status_level' => 'success',
            'verified_at' => now()->toISOString(),
            'checked_at' => now()->toISOString(),
            'api_unreachable' => true,
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
        $status = $data['subscription']['status'] ?? $data['status'] ?? '';
        if (in_array($status, $blockedStatuses)) {
            return false;
        }

        // Check if grace period is enabled in config
        if (!config('license.grace_period.enabled', true)) {
            return false;
        }

        // Need to have an expiration date to calculate grace period
        $expiryStr = $data['subscription']['expires_at'] ?? $data['client']['license_expires_at'] ?? null;
        if (empty($expiryStr)) {
            return false;
        }

        // Only expired licenses get grace period
        $isExpired = $data['subscription']['is_expired'] ?? $data['is_expired'] ?? false;
        if (!$isExpired) {
            return false;
        }

        try {
            $expiryDate = Carbon::parse($expiryStr);
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
        if (isset($data['subscription']['days_until_expiry']) && $data['subscription']['days_until_expiry'] !== null) {
            return (int) $data['subscription']['days_until_expiry'];
        }

        $expiryStr = $data['subscription']['expires_at'] ?? $data['client']['license_expires_at'] ?? null;
        if (empty($expiryStr)) {
            return null;
        }

        try {
            $expiryDate = Carbon::parse($expiryStr);
            return (int) now()->diffInDays($expiryDate, false); // false = return negative if expired
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

        if ($data['valid'] ?? false) {
            $days = $this->getDaysUntilExpiry($data);

            if ($days !== null) {
                if ($days <= 30 && $days > 7) {
                    return 'warning';
                } elseif ($days <= 7 && $days >= 0) {
                    return 'danger';
                }
            }
            return 'success';
        }

        if ($this->isInGracePeriod($data)) {
            return 'grace';
        }

        $status = $data['subscription']['status'] ?? $data['status'] ?? '';
        if (in_array($status, ['suspended', 'cancelled', 'revoked', 'terminated'])) {
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