<?php
namespace App\Http\Controllers\Vendor;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('vendor.auth.register');
    }

    public function register(Request $request)
    {
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
                $user = User::create([
                    'name' => $request->owner_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => Hash::make($request->password),
                    'status' => 'pending'
                ]);

                $user->assignRole('vendor');

                $user->vendor()->create([
                    'business_name' => $request->business_name,
                    'gst_number' => $request->gst_number,
                    'address' => $request->address,
                    'status' => 'pending'
                ]);
            });

            return redirect()->route('login')->with('success', 'Registration successful! Your account is pending admin approval.');

        } catch (\Exception $e) {
            Log::error('Vendor Registration Error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return back()->withInput()->withErrors(['error' => 'Registration failed: ' . $e->getMessage()]);
        }
    }


}