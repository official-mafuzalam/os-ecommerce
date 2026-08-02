<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackAffiliate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (setting('affiliate_marketing_status', true) && $request->has('ref')) {
            $affiliate = \App\Models\Affiliate::where('referral_code', $request->query('ref'))
                ->where('status', 'active')
                ->first();

            if ($affiliate) {
                // Store affiliate ID in a cookie for 30 days
                \Illuminate\Support\Facades\Cookie::queue('affiliate_id', $affiliate->id, 60 * 24 * 30);
            }
        }

        return $next($request);
    }
}
