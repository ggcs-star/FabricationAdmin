<?php
namespace App\Http\Controllers\Vendor;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // 1. Log facade add kiya

class AuthController extends Controller
{
    // Registration Form dikhane ke liye
    public function showRegisterForm()
    {
        return view('vendor.auth.register'); // Blade file
    }

    // Form submit handle karne ke liye
    public function register(Request $request)
    {
        // 1. Validation
        $validated = $request->validate([
            'owner_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|unique:users|max:15',
            'password' => 'required|string|min:8|confirmed',
            'business_name' => 'required|string|max:255',
            'gst_number' => 'nullable|string',
            'address' => 'required|string',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // 2. Create Core User
                $user = User::create([
                    'name' => $request->owner_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => Hash::make($request->password),
                    'status' => 'pending' // Admin check karega
                ]);

                // Assign Role
                $user->assignRole('vendor');

                // 3. Create Vendor Profile
                $user->vendor()->create([
                    'business_name' => $request->business_name,
                    'gst_number' => $request->gst_number,
                    'address' => $request->address,
                    'status' => 'pending'
                ]);
            });

            // 4. Redirect with Success Message
            return redirect()->route('login')->with('success', 'Registration successful! Your account is pending admin approval.');

        } catch (\Exception $e) {
            // 2. Error ko Laravel ki log file me save karna
            Log::error('Vendor Registration Error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            // 3. Screen par real error message dikhana (taaki jaldi debug ho sake)
            return back()->withInput()->withErrors(['error' => 'Registration failed: ' . $e->getMessage()]);
        }
    }

    public function loginForm()
    {
        return view('auth.login'); // Ye view humne pichle steps me banaya tha
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = auth()->user();

            if ($user->hasRole('vendor')) {
                // Good practice to track last login
                $user->update(['last_login_at' => now()]); 
                return redirect()->route('vendor.dashboard');
            }

            // Agar koi customer ya dusra user login karne ki koshish kare
            Auth::logout();
            return back()->withErrors(['email' => 'Access Denied. Only partners can login here.']);
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'You have been successfully logged out.');
    }
}