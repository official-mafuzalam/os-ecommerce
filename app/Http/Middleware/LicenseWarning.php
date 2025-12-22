<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\LicenseService;
use Symfony\Component\HttpFoundation\Response;

class LicenseWarning
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
        $licenseStatus = $this->licenseService->getStatus();

        // Share license status with all views
        view()->share('licenseStatus', $licenseStatus);

        // Add flash messages for warnings
        if ($licenseStatus['status_level'] === 'warning') {
            $request->session()->flash(
                'license.warning',
                "Your license will expire in {$licenseStatus['days_until_expiry']} days. Please renew soon."
            );
        } elseif ($licenseStatus['status_level'] === 'danger') {
            $request->session()->flash(
                'license.danger',
                "Your license expires in {$licenseStatus['days_until_expiry']} days! Renew immediately to avoid disruption."
            );
        } elseif ($licenseStatus['status_level'] === 'grace') {
            $request->session()->flash(
                'license.danger',
                "Your license has expired! You're in a grace period. Renew immediately."
            );
        } elseif ($licenseStatus['api_unreachable'] ?? false) {
            $request->session()->flash(
                'license.info',
                "Unable to verify license status. Please check your internet connection."
            );
        }

        $request->attributes->set('license_status', $licenseStatus);

        return $next($request);
    }
}