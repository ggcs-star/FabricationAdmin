<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = auth()->user();

            if ($user->hasRole('admin')) {
                // Good practice to update login time here too
                $user->update(['last_login_at' => now()]); 
                return redirect()->route('admin.dashboard');
            }

            // Not an admin
            Auth::logout();
            return back()->withErrors(['email' => 'You do not have administrative privileges.']);
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }
}