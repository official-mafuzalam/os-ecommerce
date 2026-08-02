<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\Affiliate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('affiliate.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('affiliate')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('affiliate.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegistrationForm()
    {
        return view('affiliate.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:affiliates',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $affiliate = Affiliate::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'referral_code' => self::generateReferralCode($request->name),
            'status' => 'active',
        ]);

        Auth::guard('affiliate')->login($affiliate);

        return redirect()->route('affiliate.dashboard')->with('success', 'Affiliate registered successfully.');
    }

    public function logout(Request $request)
    {
        Auth::guard('affiliate')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('affiliate.login');
    }
    private static function generateReferralCode(string $name): string
    {
        // Take first 3 letters of name (letters only, uppercase)
        $prefix = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $name), 0, 3));
        $prefix = str_pad($prefix, 3, 'X'); // pad if name is very short

        do {
            $code = $prefix . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
        } while (Affiliate::where('referral_code', $code)->exists());

        return $code; // e.g. "MDR042" — always 6 chars
    }
}
