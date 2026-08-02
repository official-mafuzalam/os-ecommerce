<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Affiliate;
use App\Models\AffiliateEarning;
use Illuminate\Http\Request;

class AffiliateController extends Controller
{
    /**
     * List all affiliates with their total earnings.
     */
    public function index(Request $request)
    {
        $query = Affiliate::withCount('earnings')
            ->withSum(['earnings as approved_earnings' => function ($q) {
                $q->where('status', 'approved');
            }], 'amount')
            ->withSum(['earnings as pending_earnings' => function ($q) {
                $q->where('status', 'pending');
            }], 'amount');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('referral_code', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $affiliates = $query->latest()->paginate(15);

        $totalAffiliates  = Affiliate::count();
        $activeAffiliates = Affiliate::where('status', 'active')->count();
        $totalApproved    = AffiliateEarning::where('status', 'approved')->sum('amount');
        $totalPending     = AffiliateEarning::where('status', 'pending')->sum('amount');

        return view('admin.affiliates.index', compact(
            'affiliates',
            'totalAffiliates',
            'activeAffiliates',
            'totalApproved',
            'totalPending'
        ));
    }

    /**
     * Show a single affiliate's details and earnings.
     */
    public function show(Affiliate $affiliate)
    {
        $earnings = $affiliate->earnings()
            ->with('order')
            ->latest()
            ->paginate(15);

        $totalEarnings   = $affiliate->earnings()->where('status', 'approved')->sum('amount');
        $pendingEarnings = $affiliate->earnings()->where('status', 'pending')->sum('amount');

        return view('admin.affiliates.show', compact(
            'affiliate',
            'earnings',
            'totalEarnings',
            'pendingEarnings'
        ));
    }

    /**
     * Toggle affiliate status (active / inactive).
     */
    public function toggleStatus(Affiliate $affiliate)
    {
        $affiliate->update([
            'status' => $affiliate->status === 'active' ? 'inactive' : 'active'
        ]);

        return back()->with('success', 'Affiliate status updated.');
    }

    /**
     * Update a single earning status (e.g. mark as paid).
     */
    public function updateEarningStatus(Request $request, AffiliateEarning $earning)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,paid,cancelled'
        ]);

        $earning->update(['status' => $request->status]);

        return back()->with('success', 'Earning status updated.');
    }

    /**
     * Delete an affiliate.
     */
    public function destroy(Affiliate $affiliate)
    {
        $affiliate->delete();
        return redirect()->route('admin.affiliates.index')->with('success', 'Affiliate deleted.');
    }
}
