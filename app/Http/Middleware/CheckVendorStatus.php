<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckVendorStatus
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->hasRole('vendor')) {
            $vendor = $user->vendor;

            if (!$vendor || $vendor->status !== 'approved') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->withErrors([
                    'email' => 'Your account is pending approval by the Admin.'
                ]);
            }
        }

        return $next($request);
    }
}