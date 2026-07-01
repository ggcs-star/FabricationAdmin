<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        $query = Vendor::query()->with('user:id,name,email,phone');

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        if ($request->filled('search')) {
            $search = '%' . $request->string('search') . '%';
            $query->where(function ($q) use ($search) {
                $q->where('business_name', 'like', $search)
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', $search)
                            ->orWhere('email', 'like', $search)
                            ->orWhere('phone', 'like', $search);
                    });
            });
        }

        return response()->json($query->latest()->paginate(15));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id', Rule::unique('vendors', 'user_id')],
            'business_name' => ['required', 'string', 'max:255'],
            'gst_number' => ['nullable', 'string', 'max:255'],
            'pan_number' => ['nullable', 'string', 'max:255'],
            'aadhaar_number' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'status' => ['sometimes', Rule::in(['pending', 'approved', 'rejected', 'suspended'])],
            'approved_by' => ['nullable', 'exists:users,id'],
            'approved_at' => ['nullable', 'date'],
        ]);

        $vendor = Vendor::create($data);

        return response()->json($vendor->load('user:id,name,email,phone'), 201);
    }

    public function show(Vendor $vendor)
    {
        return response()->json($vendor->load('user:id,name,email,phone'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        $data = $request->validate([
            'business_name' => ['sometimes', 'string', 'max:255'],
            'gst_number' => ['nullable', 'string', 'max:255'],
            'pan_number' => ['nullable', 'string', 'max:255'],
            'aadhaar_number' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'status' => ['sometimes', Rule::in(['pending', 'approved', 'rejected', 'suspended'])],
            'approved_by' => ['nullable', 'exists:users,id'],
            'approved_at' => ['nullable', 'date'],
        ]);

        $vendor->update($data);

        return response()->json($vendor->fresh()->load('user:id,name,email,phone'));
    }

    public function destroy(Vendor $vendor)
    {
        $vendor->delete();

        return response()->json(['message' => 'Vendor deleted successfully.']);
    }
}
