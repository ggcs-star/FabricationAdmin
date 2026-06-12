<?php
namespace App\Http\Controllers\Admin;

use App\Models\Vendor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function pendingList()
    {
        $vendors = Vendor::with('user')->where('status', 'pending')->latest()->paginate(10);

        return view('admin.vendors.pending', compact('vendors'));
    }

    public function approve($id)
    {
        $vendor = Vendor::findOrFail($id);

        $vendor->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now()
        ]);

        $vendor->user->update(['status' => 'active']);

        return back()->with('success', 'Vendor has been approved successfully.');
    }

    public function reject($id)
    {
        $vendor = Vendor::findOrFail($id);

        $vendor->update(['status' => 'rejected']);
        $vendor->user->update(['status' => 'suspended']);

        return back()->with('success', 'Vendor application rejected.');
    }
}