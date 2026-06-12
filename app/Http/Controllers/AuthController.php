<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Show Global Login Form
    public function loginForm()
    {
        return view('auth.login'); // Ek common login blade file
    }

    // 2. Handle Login Logic & Smart Redirection
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = auth()->user();
            
            // Track last login time
            $user->update(['last_login_at' => now()]);

            // SMART REDIRECTION BASED ON SPATIE ROLES
            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            }

            if ($user->hasRole('vendor')) {
                return redirect()->route('vendor.dashboard');
            }

            // Agar koi customer galti se website par login kare
            if ($user->hasRole('customer')) {
                Auth::logout();
                return back()->withErrors(['email' => 'Customers must use the Mobile App to login.']);
            }

            // Default fallback
            Auth::logout();
            return back()->withErrors(['email' => 'Unauthorized role.']);
        }

        return back()->withErrors(['email' => 'Invalid email or password.']);
    }

    // 3. Handle Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login')->with('success', 'Logged out successfully.');
    }
}