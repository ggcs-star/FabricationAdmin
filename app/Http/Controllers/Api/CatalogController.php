<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Service;
use App\Models\Vendor;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function vendors(Request $request)
    {
        $query = Vendor::query()
            ->with('user:id,name,email,phone')
            ->where('status', 'approved');

        if ($request->filled('search')) {
            $search = '%' . $request->string('search') . '%';
            $query->where(function ($q) use ($search) {
                $q->where('business_name', 'like', $search)
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', $search);
                    });
            });
        }

        return response()->json($query->latest()->paginate(15));
    }

    public function categories(Request $request)
    {
        $query = Category::query()->where('is_active', true);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->string('search') . '%');
        }

        return response()->json($query->latest()->paginate(15));
    }

    public function services(Request $request)
    {
        $query = Service::query()
            ->with(['vendor:id,business_name', 'category:id,name'])
            ->where('status', 'active')
            ->whereHas('vendor', function ($q) {
                $q->where('status', 'approved');
            });

        if ($request->filled('vendor_id')) {
            $query->where('vendor_id', $request->integer('vendor_id'));
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->integer('category_id'));
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->string('search') . '%');
        }

        return response()->json($query->latest()->paginate(15));
    }

    public function products(Request $request)
    {
        $query = Product::query()
            ->with(['vendor:id,business_name', 'category:id,name', 'service:id,name'])
            ->where('status', 'active')
            ->whereHas('vendor', function ($q) {
                $q->where('status', 'approved');
            });

        if ($request->filled('vendor_id')) {
            $query->where('vendor_id', $request->integer('vendor_id'));
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->integer('category_id'));
        }

        if ($request->filled('service_id')) {
            $query->where('service_id', $request->integer('service_id'));
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->string('search') . '%');
        }

        return response()->json($query->latest()->paginate(15));
    }
}
