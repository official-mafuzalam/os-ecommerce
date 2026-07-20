<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q');

        $products = Product::with(['category', 'brand'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->where('is_active', true)
            ->when($query, function ($q) use ($query) {
                $q->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%")
                        ->orWhere('sku', 'like', "%{$query}%")
                        ->orWhereHas('category', function ($q) use ($query) {
                            $q->where('name', 'like', "%{$query}%");
                        })
                        ->orWhereHas('brand', function ($q) use ($query) {
                            $q->where('name', 'like', "%{$query}%");
                        });
                });
            })
            ->orderBy('name')
            ->paginate(12);

        return view('public.search', compact('products', 'query'));
    }


    public function liveSearch(Request $request): JsonResponse
    {
        $query = $request->get('q');
        $results = [];

        if ($query && strlen($query) >= 2) {
            $results = Product::where('is_active', true)
                ->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%");
                })
                ->take(5)
                ->get()
                ->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'slug' => $product->slug,
                        'price' => $product->price,
                        'price_formatted' => number_format($product->price) . ' TK',
                        'image_url' => $product->images->where('is_primary', true)->first() ? Storage::url($product->images->where('is_primary', true)->first()->image_path) : asset('assets/placeholder.svg'),
                    ];
                });
        }

        return response()->json($results);
    }
}
