<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with(['vendor:id,business_name', 'category:id,name'])
            ->latest()
            ->paginate(15);

        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $vendors = Vendor::where('status', 'approved')->orderBy('business_name')->get();

        return view('admin.services.create', compact('categories', 'vendors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'vendor_id' => ['required', 'exists:vendors,id'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'base_price' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $data['slug'] = Str::slug($data['name']);

        Service::create($data);

        return redirect()->route('admin.services.index')->with('success', 'Service created successfully.');
    }

    public function edit(Service $service)
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $vendors = Vendor::where('status', 'approved')->orderBy('business_name')->get();

        return view('admin.services.edit', compact('service', 'categories', 'vendors'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'vendor_id' => ['required', 'exists:vendors,id'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'base_price' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $data['slug'] = Str::slug($data['name']);

        $service->update($data);

        return redirect()->route('admin.services.index')->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Service deleted successfully.');
    }
}
