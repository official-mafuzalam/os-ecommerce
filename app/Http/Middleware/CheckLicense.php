<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\LicenseService;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class CheckLicense
{
    protected $licenseService;

    public function __construct(LicenseService $licenseService)
    {
        $this->licenseService = $licenseService;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip for specific routes if needed
        if ($this->shouldSkip($request)) {
            return $next($request);
        }

        $licenseStatus = $this->licenseService->getStatus();

        // Use null coalescing operator to avoid undefined key errors
        $isValid = $licenseStatus['valid'] ?? false;
        $isInGracePeriod = $licenseStatus['is_in_grace_period'] ?? false;
        $apiUnreachable = $licenseStatus['api_unreachable'] ?? false;
        $isExpired = $licenseStatus['is_expired'] ?? false;
        $status = $licenseStatus['status'] ?? 'unknown';

        // Store license status in session for the warning page
        session(['license_status' => $licenseStatus]);

        // Check for suspended/cancelled status - these should block immediately
        $isBlockedStatus = in_array($status, ['suspended', 'cancelled', 'revoked', 'terminated']);

        // Block if: invalid AND not in grace period, OR has blocked status
        if ((!$isValid && !$isInGracePeriod) || $isBlockedStatus) {
            // If API is unreachable, show warning but allow access
            if ($apiUnreachable) {
                $request->session()->flash('license.warning', 'Unable to verify license. Using cached data.');
                return $next($request);
            }

            // Add specific message based on why license is invalid
            if ($isBlockedStatus) {
                $statusMessages = [
                    'suspended' => 'License has been suspended.',
                    'cancelled' => 'License has been cancelled.',
                    'revoked' => 'License has been revoked.',
                    'terminated' => 'License has been terminated.'
                ];

                $message = $statusMessages[$status] ?? "License status: $status";
                $request->session()->flash('license.danger', $message);

            } elseif ($isExpired) {
                $expiryDate = $licenseStatus['client']['license_expires_at'] ?? 'unknown';
                $daysAgo = abs($licenseStatus['days_until_expiry'] ?? 0);

                $message = "Your license expired " . ($daysAgo > 1 ? "$daysAgo days ago" : "1 day ago") .
                    " (on " . Carbon::parse($expiryDate)->format('F j, Y') . "). ";

                if (!$isInGracePeriod) {
                    $message .= "The grace period has ended.";
                }

                $request->session()->flash('license.danger', $message);
            } else {
                $request->session()->flash(
                    'license.danger',
                    'License is invalid. Status: ' . $status
                );
            }

            return redirect()->route('license.warning');
        }

        // If in grace period, show warning but allow access
        if (!$isValid && $isInGracePeriod) {
            $daysLeft = $licenseStatus['days_until_expiry'] ?? 0;
            $graceDays = config('license.grace_period.days', 7);
            $daysRemaining = $graceDays + $daysLeft; // daysLeft is negative

            $request->session()->flash(
                'license.warning',
                "License expired. You're in a grace period. $daysRemaining days remaining to renew."
            );
        }

        // Add license data to all requests
        $request->attributes->set('license_status', $licenseStatus);

        return $next($request);
    }

    /**
     * Check if middleware should be skipped
     */
    private function shouldSkip(Request $request): bool
    {
        $skipRoutes = [
            'license.warning',
            'license.refresh',
            'license.update',
            'logout',
        ];

        return in_array($request->route()->getName(), $skipRoutes);
    }
}