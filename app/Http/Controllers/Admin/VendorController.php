<?php
namespace App\Http\Controllers\Admin;

use App\Models\Vendor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    // Pending vendors ki list dikhana
    public function pendingList()
    {
        // Eager load User data to avoid N+1 query problem
        $vendors = Vendor::with('user')->where('status', 'pending')->latest()->paginate(10);
        
        return view('admin.vendors.pending', compact('vendors')); // Blade file
    }

    // Vendor ko approve karna
    public function approve($id)
    {
        $vendor = Vendor::findOrFail($id);

        // Update Vendor Profile Table
        $vendor->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now()
        ]);

        // Update User Table Status
        $vendor->user->update(['status' => 'active']);

        return back()->with('success', 'Vendor has been approved successfully.');
    }

    // Vendor ko reject karna
    public function reject($id)
    {
        $vendor = Vendor::findOrFail($id);
        
        $vendor->update(['status' => 'rejected']);
        $vendor->user->update(['status' => 'suspended']);

        return back()->with('success', 'Vendor application rejected.');
    }
}