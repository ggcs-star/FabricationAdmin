<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login'); 
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = auth()->user();
            
            $user->update(['last_login_at' => now()]);

            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            }

            if ($user->hasRole('vendor')) {
                return redirect()->route('vendor.dashboard');
            }

            if ($user->hasRole('customer')) {
                Auth::logout();
                return back()->withErrors(['email' => 'Customers must use the Mobile App to login.']);
            }

            Auth::logout();
            return back()->withErrors(['email' => 'Unauthorized role.']);
        }

        return back()->withErrors(['email' => 'Invalid email or password.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login')->with('success', 'Logged out successfully.');
    }
}