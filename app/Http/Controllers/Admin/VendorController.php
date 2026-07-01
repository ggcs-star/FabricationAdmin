<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::with('user:id,name,email,phone')->latest()->paginate(15);

        return view('admin.vendors.index', compact('vendors'));
    }

    public function create()
    {
        return view('admin.vendors.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20', 'unique:users,phone'],
            'password' => ['required', 'string', 'min:8'],
            'business_name' => ['required', 'string', 'max:255'],
            'gst_number' => ['nullable', 'string', 'max:255'],
            'pan_number' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'status' => ['required', 'in:pending,approved,rejected,suspended'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'status' => $data['status'] === 'approved' ? 'active' : 'pending',
        ]);

        $user->assignRole('vendor');

        Vendor::create([
            'user_id' => $user->id,
            'business_name' => $data['business_name'],
            'gst_number' => $data['gst_number'] ?? null,
            'pan_number' => $data['pan_number'] ?? null,
            'address' => $data['address'] ?? null,
            'status' => $data['status'],
            'approved_at' => $data['status'] === 'approved' ? now() : null,
        ]);

        return redirect()->route('admin.vendors.index')->with('success', 'Vendor created successfully.');
    }

    public function edit(Vendor $vendor)
    {
        $vendor->load('user');

        return view('admin.vendors.edit', compact('vendor'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $vendor->user_id],
            'phone' => ['required', 'string', 'max:20', 'unique:users,phone,' . $vendor->user_id],
            'business_name' => ['required', 'string', 'max:255'],
            'gst_number' => ['nullable', 'string', 'max:255'],
            'pan_number' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'status' => ['required', 'in:pending,approved,rejected,suspended'],
        ]);

        $vendor->user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'status' => $data['status'] === 'approved' ? 'active' : 'inactive',
        ]);

        $vendor->update([
            'business_name' => $data['business_name'],
            'gst_number' => $data['gst_number'] ?? null,
            'pan_number' => $data['pan_number'] ?? null,
            'address' => $data['address'] ?? null,
            'status' => $data['status'],
            'approved_at' => $data['status'] === 'approved' ? ($vendor->approved_at ?? now()) : null,
        ]);

        return redirect()->route('admin.vendors.index')->with('success', 'Vendor updated successfully.');
    }

    public function destroy(Vendor $vendor)
    {
        $vendor->user?->delete();
        $vendor->delete();

        return redirect()->route('admin.vendors.index')->with('success', 'Vendor deleted successfully.');
    }

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
            'approved_at' => now(),
        ]);

        $vendor->user?->update(['status' => 'active']);

        return back()->with('success', 'Vendor has been approved successfully.');
    }

    public function reject($id)
    {
        $vendor = Vendor::findOrFail($id);

        $vendor->update(['status' => 'rejected']);
        $vendor->user?->update(['status' => 'inactive']);

        return back()->with('success', 'Vendor application rejected.');
    }
}
