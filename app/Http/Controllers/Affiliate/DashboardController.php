<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $affiliate = Auth::guard('affiliate')->user();
        $earnings = $affiliate->earnings()->with('order')->latest()->get();
        
        $totalEarnings = $earnings->where('status', 'approved')->sum('amount');
        $pendingEarnings = $earnings->where('status', 'pending')->sum('amount');
        
        return view('affiliate.dashboard', compact('affiliate', 'earnings', 'totalEarnings', 'pendingEarnings'));
    }
}
