<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Missing in original

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // 1. Mandatory Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|unique:users|max:20',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        // 2. Safe Creation
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password), // Using Hash facade
            'status' => 'active'
        ]);

        $user->assignRole('customer');

        // Optional: Auto-login after registration
        $token = auth('api')->login($user);

        return response()->json([
            'status' => true,
            'message' => 'Registration Successful',
            'token' => $token, // Send token immediately
            'token_type' => 'Bearer'
        ], 201);
    }

    public function login(Request $request)
    {
        // 1. Validate Input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid Credentials'
            ], 401);
        }

        // 2. Role Security Check
        $user = auth('api')->user();
        if (!$user->hasRole('customer')) {
            auth('api')->logout();
            return response()->json([
                'status' => false,
                'message' => 'Access Denied. Only customers can login here.'
            ], 403);
        }

        // 3. Update Last Login (Tracking)
        $user->update(['last_login_at' => now()]);

        return response()->json([
            'status' => true,
            'token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60 // Good practice for frontend
        ]);
    }

    // ... (me & logout methods remain the same) ...
}