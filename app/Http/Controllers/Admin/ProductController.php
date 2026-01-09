<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Deal;
use App\Models\ProductAttribute;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:products_manage')->only([
            'index',
            'create',
            'store',
            'edit',
            'update',
            'destroy',
            'trash',
            'restore',
            'forceDelete',
            'bulkDestroy',
            'bulkForceDelete',
            'bulkRestore',
            'toggleStatus',
            'toggleFeatured',
            'setPrimaryImage',
            'editDeals',
            'assignDeals',
            'removeDeal',
            'generateDescription'
        ]);
    }

    protected $perPageProducts = 20;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $brands = Brand::where('is_active', true)->get();
        $categories = Category::where('is_active', true)->get();

        $products = Product::with(['category', 'brand'])
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->when($request->brand, function ($query, $brand) {
                $query->where('brand_id', $brand);
            })
            ->when($request->category, function ($query, $category) {
                $query->where('category_id', $category);
            })
            ->when($request->status, function ($query, $status) {
                if ($status === 'active') {
                    $query->where('is_active', true);
                } elseif ($status === 'inactive') {
                    $query->where('is_active', false);
                }
            })
            ->latest()
            ->paginate($this->perPageProducts)
            ->appends($request->all());

        return view('admin.products.index', compact('products', 'brands', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        $brands = Brand::where('is_active', true)->get();
        $allAttributes = Attribute::where('is_active', true)->get();
        $product = new Product();

        return view('admin.products.create', compact('categories', 'brands', 'product', 'allAttributes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        logger('All request data:', $request->all());
        logger('Product attributes:', ['product_attributes' => $request->input('product_attributes')]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'buy_price' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'sku' => 'required|string|unique:products,sku',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'image_gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'specifications' => 'nullable|json',
            'is_active' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean',
            'product_attributes' => 'nullable|array',
            'product_attributes.*.id' => 'required|exists:attributes,id',
            'product_attributes.*.values' => 'required|array',
            'product_attributes.*.values.*' => 'string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $validated['slug'] = Str::slug($validated['name']);
            $validated['is_active'] = $request->boolean('is_active');
            $validated['is_featured'] = $request->boolean('is_featured');

            if (!empty($validated['specifications'])) {
                $validated['specifications'] = json_decode($validated['specifications'], true);
            }

            // Create product
            $product = Product::create($validated);

            if ($request->filled('product_attributes')) { // Changed from attributes
                foreach ($request->product_attributes as $index => $attributeData) { // Changed from attributes
                    if (!empty($attributeData['id']) && !empty($attributeData['values'])) {
                        foreach ($attributeData['values'] as $valueIndex => $value) {
                            ProductAttribute::create([
                                'product_id' => $product->id,
                                'attribute_id' => $attributeData['id'],
                                'value' => trim($value),
                                'order' => $valueIndex
                            ]);
                        }
                    }
                }
            }


            // Handle gallery images (compress to <= 200 KB when possible)
            if ($request->hasFile('image_gallery')) {
                foreach ($request->file('image_gallery') as $index => $image) {
                    $mime = $image->getMimeType();
                    $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $filename = Str::slug($originalName) . '-' . time() . '-' . $index . '.jpg';
                    $publicDir = storage_path('app/public/products/gallery');
                    $targetPath = $publicDir . DIRECTORY_SEPARATOR . $filename;

                    if (!file_exists($publicDir)) {
                        mkdir($publicDir, 0755, true);
                    }

                    try {
                        switch ($mime) {
                            case 'image/png':
                                $src = imagecreatefrompng($image->getPathname());
                                break;
                            case 'image/gif':
                                $src = imagecreatefromgif($image->getPathname());
                                break;
                            case 'image/webp':
                                if (function_exists('imagecreatefromwebp')) {
                                    $src = imagecreatefromwebp($image->getPathname());
                                } else {
                                    $src = imagecreatefromjpeg($image->getPathname());
                                }
                                break;
                            default:
                                $src = imagecreatefromjpeg($image->getPathname());
                                break;
                        }

                        $w = imagesx($src);
                        $h = imagesy($src);

                        $dst = imagecreatetruecolor($w, $h);
                        $white = imagecolorallocate($dst, 255, 255, 255);
                        imagefill($dst, 0, 0, $white);
                        imagecopyresampled($dst, $src, 0, 0, 0, 0, $w, $h, $w, $h);

                        $quality = 85;
                        imagejpeg($dst, $targetPath, $quality);

                        imagedestroy($src);
                        imagedestroy($dst);

                        $maxBytes = 200 * 1024; // 200 KB

                        while (filesize($targetPath) > $maxBytes && $quality > 30) {
                            $quality -= 5;
                            $src = imagecreatefromjpeg($targetPath);
                            $dst = imagecreatetruecolor(imagesx($src), imagesy($src));
                            $white = imagecolorallocate($dst, 255, 255, 255);
                            imagefill($dst, 0, 0, $white);
                            imagecopyresampled($dst, $src, 0, 0, 0, 0, imagesx($src), imagesy($src), imagesx($src), imagesy($src));
                            imagejpeg($dst, $targetPath, $quality);
                            imagedestroy($src);
                            imagedestroy($dst);
                        }

                        while (filesize($targetPath) > $maxBytes) {
                            $src = imagecreatefromjpeg($targetPath);
                            $origW = imagesx($src);
                            $origH = imagesy($src);
                            $newW = (int) ($origW * 0.9);
                            $newH = (int) ($origH * 0.9);

                            if ($newW < 400 || $newH < 400) {
                                imagedestroy($src);
                                break;
                            }

                            $dst = imagecreatetruecolor($newW, $newH);
                            $white = imagecolorallocate($dst, 255, 255, 255);
                            imagefill($dst, 0, 0, $white);
                            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newW, $newH, $origW, $origH);
                            imagejpeg($dst, $targetPath, $quality);
                            imagedestroy($src);
                            imagedestroy($dst);
                        }

                        $galleryPath = 'products/gallery/' . $filename;
                    } catch (\Exception $e) {
                        // fallback to storing original file
                        $galleryPath = $image->store('products/gallery', 'public');
                    }

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $galleryPath,
                        'is_primary' => $index === 0,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Product created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            // Log::error('Product creation failed: ' . $e->getMessage(), [
            //     'trace' => $e->getTraceAsString()
            // ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'Something went wrong while creating the product.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $allDeals = Deal::active()->ordered()->get();
        $product->load(['category', 'brand', 'images']);

        $groupedAttributes = collect($product->attributes)
            ->groupBy('id')
            ->map(function ($items) {
                return [
                    'name' => $items->first()->name,
                    'values' => $items->pluck('pivot.value')->unique()->toArray(),
                ];
            });

        return view('admin.products.show', compact('product', 'allDeals', 'groupedAttributes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->get();
        $brands = Brand::where('is_active', true)->get();
        $allAttributes = Attribute::where('is_active', true)->get();

        // Load product attributes with pivot values
        $product->load('attributes');

        // Group attributes by attribute_id and collect values
        $groupedAttributes = collect($product->attributes)
            ->groupBy('id')
            ->map(function ($items) {
                return [
                    'id' => $items->first()->id,
                    'name' => $items->first()->name,
                    'values' => $items->pluck('pivot.value')->toArray()
                ];
            })->values(); // reset keys

        return view('admin.products.edit', compact(
            'product',
            'categories',
            'brands',
            'allAttributes',
            'groupedAttributes'
        ));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Debug the request data
        logger('Request all data:', $request->all());
        logger('Product attributes in request:', $request->input('product_attributes', []));

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'buy_price' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'image_gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'specifications' => 'nullable|json',
            'is_active' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean',
            'product_attributes' => 'nullable|array', // Changed from attributes
            'product_attributes.*.id' => 'required|exists:attributes,id',
            'product_attributes.*.values' => 'required|array',
            'product_attributes.*.values.*' => 'string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $validated['slug'] = Str::slug($validated['name']);
            $validated['is_active'] = $request->boolean('is_active');
            $validated['is_featured'] = $request->boolean('is_featured');

            // Decode specifications JSON
            if (!empty($validated['specifications'])) {
                $validated['specifications'] = json_decode($validated['specifications'], true);
            }

            // Update product
            $product->update($validated);

            // --- Handle product attributes ---
            // Remove all old attributes
            ProductAttribute::where('product_id', $product->id)->delete();

            if ($request->filled('product_attributes')) { // Changed from attributes
                foreach ($request->product_attributes as $order => $attributeData) { // Changed from attributes
                    $attrId = $attributeData['id'] ?? null;
                    $values = $attributeData['values'] ?? [];

                    if ($attrId && !empty($values)) {
                        foreach ($values as $valueIndex => $value) {
                            ProductAttribute::create([
                                'product_id' => $product->id,
                                'attribute_id' => (int) $attrId,
                                'value' => trim($value),
                                'order' => $valueIndex,
                            ]);
                        }
                    }
                }

                // Log::info('Product attributes synced', [
                //     'product_id' => $product->id,
                //     'product_attributes' => $request->input('product_attributes', []) // Changed from attributes
                // ]);
            }

            // Handle gallery images (compress to <= 200 KB when possible)
            if ($request->hasFile('image_gallery')) {
                foreach ($request->file('image_gallery') as $index => $image) {
                    $mime = $image->getMimeType();
                    $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $filename = Str::slug($originalName) . '-' . time() . '-' . $index . '.jpg';
                    $publicDir = storage_path('app/public/products/gallery');
                    $targetPath = $publicDir . DIRECTORY_SEPARATOR . $filename;

                    if (!file_exists($publicDir)) {
                        mkdir($publicDir, 0755, true);
                    }

                    // Check if GD functions are available
                    if (function_exists('imagecreatefromjpeg') && function_exists('imagejpeg')) {
                        try {
                            switch ($mime) {
                                case 'image/png':
                                    $src = imagecreatefrompng($image->getPathname());
                                    break;
                                case 'image/gif':
                                    $src = imagecreatefromgif($image->getPathname());
                                    break;
                                case 'image/webp':
                                    if (function_exists('imagecreatefromwebp')) {
                                        $src = imagecreatefromwebp($image->getPathname());
                                    } else {
                                        $src = imagecreatefromjpeg($image->getPathname());
                                    }
                                    break;
                                default:
                                    $src = imagecreatefromjpeg($image->getPathname());
                                    break;
                            }

                            $w = imagesx($src);
                            $h = imagesy($src);

                            $dst = imagecreatetruecolor($w, $h);
                            $white = imagecolorallocate($dst, 255, 255, 255);
                            imagefill($dst, 0, 0, $white);
                            imagecopyresampled($dst, $src, 0, 0, 0, 0, $w, $h, $w, $h);

                            $quality = 85;
                            imagejpeg($dst, $targetPath, $quality);

                            imagedestroy($src);
                            imagedestroy($dst);

                            $maxBytes = 200 * 1024; // 200 KB

                            while (filesize($targetPath) > $maxBytes && $quality > 30) {
                                $quality -= 5;
                                $src = imagecreatefromjpeg($targetPath);
                                $dst = imagecreatetruecolor(imagesx($src), imagesy($src));
                                $white = imagecolorallocate($dst, 255, 255, 255);
                                imagefill($dst, 0, 0, $white);
                                imagecopyresampled($dst, $src, 0, 0, 0, 0, imagesx($src), imagesy($src), imagesx($src), imagesy($src));
                                imagejpeg($dst, $targetPath, $quality);
                                imagedestroy($src);
                                imagedestroy($dst);
                            }

                            while (filesize($targetPath) > $maxBytes) {
                                $src = imagecreatefromjpeg($targetPath);
                                $origW = imagesx($src);
                                $origH = imagesy($src);
                                $newW = (int) ($origW * 0.9);
                                $newH = (int) ($origH * 0.9);

                                if ($newW < 400 || $newH < 400) {
                                    imagedestroy($src);
                                    break;
                                }

                                $dst = imagecreatetruecolor($newW, $newH);
                                $white = imagecolorallocate($dst, 255, 255, 255);
                                imagefill($dst, 0, 0, $white);
                                imagecopyresampled($dst, $src, 0, 0, 0, 0, $newW, $newH, $origW, $origH);
                                imagejpeg($dst, $targetPath, $quality);
                                imagedestroy($src);
                                imagedestroy($dst);
                            }

                            $galleryPath = 'products/gallery/' . $filename;
                        } catch (\Exception $e) {
                            // fallback to storing original file
                            $galleryPath = $image->store('products/gallery', 'public');
                        }
                    } else {
                        // GD not available, store original file
                        $galleryPath = $image->store('products/gallery', 'public');
                    }

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $galleryPath,
                        'is_primary' => $index === 0,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Product updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            // Log::error('Product update failed: ' . $e->getMessage(), [
            //     'trace' => $e->getTraceAsString()
            // ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'Something went wrong while updating the product.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete associated images
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        if ($product->image_gallery) {
            foreach ($product->image_gallery as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Display a listing of soft-deleted products.
     */
    public function trash()
    {
        $brands = Brand::where('is_active', true)->get();
        $categories = Category::where('is_active', true)->get();

        $products = Product::onlyTrashed()
            ->with(['category', 'brand'])
            ->latest()
            ->paginate($this->perPageProducts);

        return view('admin.products.trash', compact('brands', 'categories', 'products'));
    }
    /**
     * Restore a soft-deleted product.
     */
    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();
        return redirect()->route('admin.products.trash')
            ->with('success', 'Product restored successfully.');
    }

    /**
     * Bulk delete products
     */
    public function bulkDestroy(Request $request)
    {
        // Validate the request
        $request->validate([
            'selected_products' => 'required|string'
        ]);

        // Decode the JSON string
        $selectedProducts = json_decode($request->selected_products);

        if (empty($selectedProducts)) {
            return redirect()->back()->with('error', 'No products selected.');
        }

        // Soft delete the selected products
        Product::whereIn('id', $selectedProducts)->delete();

        return redirect()->route('admin.products.index')
            ->with('success', count($selectedProducts) . ' products moved to trash successfully.');
    }

    /**
     * Bulk permanently delete products
     */
    public function bulkForceDelete(Request $request)
    {
        // Validate the request
        $request->validate([
            'selected_products' => 'required|string'
        ]);

        // Decode the JSON string
        $selectedProducts = json_decode($request->selected_products);

        if (empty($selectedProducts)) {
            return redirect()->back()->with('error', 'No products selected.');
        }

        // Permanently delete the selected products
        Product::onlyTrashed()->whereIn('id', $selectedProducts)->forceDelete();

        return redirect()->route('admin.products.trash')
            ->with('success', count($selectedProducts) . ' products permanently deleted successfully.');
    }

    /**
     * Bulk restore products
     */
    public function bulkRestore(Request $request)
    {
        // Validate the request
        $request->validate([
            'selected_products' => 'required|string'
        ]);

        // Decode the JSON string
        $selectedProducts = json_decode($request->selected_products);

        if (empty($selectedProducts)) {
            return redirect()->back()->with('error', 'No products selected.');
        }

        // Restore the selected products
        Product::onlyTrashed()->whereIn('id', $selectedProducts)->restore();

        return redirect()->route('admin.products.trash')
            ->with('success', count($selectedProducts) . ' products restored successfully.');
    }

    /**
     * Permanently delete a soft-deleted product.
     */
    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->forceDelete();

        return redirect()->route('admin.products.trash')
            ->with('success', 'Product permanently deleted successfully.');
    }

    /**
     * Toggle the active status of the product.
     */
    public function toggleStatus(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);

        return back()->with('success', 'Product status updated successfully');
    }

    /**
     * Toggle the featured status of the product.
     */
    public function toggleFeatured(Product $product)
    {
        $product->update(['is_featured' => !$product->is_featured]);

        return back()->with('success', 'Product featured status updated successfully');
    }

    /**
     * Set primary image for the product.
     */
    public function setPrimaryImage(Request $request, Product $product)
    {
        $request->validate([
            'image_id' => 'required|exists:product_images,id'
        ]);

        try {
            DB::beginTransaction();

            // Reset all images to non-primary
            ProductImage::where('product_id', $product->id)
                ->update(['is_primary' => false]);

            // Set the selected image as primary
            $image = ProductImage::find($request->image_id);
            $image->is_primary = true;
            $image->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Primary image updated successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            // Log::error('Failed to set primary image: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to set primary image'
            ], 500);
        }
    }

    /**
     * Show form to assign deals to a product.
     */
    public function editDeals(Product $product)
    {
        $allDeals = Deal::orderBy('priority', 'desc')->get();

        return view('admin.products.show', compact('product', 'allDeals'));
    }

    /**
     * Assign deals to a product.
     */
    public function assignDeals(Request $request, Product $product)
    {
        $request->validate([
            'deal_ids' => 'nullable|array',
            'deal_ids.*' => 'exists:deals,id',
        ]);

        // Sync the deals (replace existing assignments)
        $syncData = [];
        if ($request->has('deal_ids')) {
            foreach ($request->deal_ids as $dealId) {
                $syncData[$dealId] = ['is_featured' => false]; // Default values
            }
        }

        $product->deals()->sync($syncData);

        return redirect()->back()
            ->with('success', 'Deal assignments updated successfully.');
    }

    /**
     * Remove a product from a deal.
     */
    public function removeDeal(Product $product, Deal $deal)
    {
        $product->deals()->detach($deal->id);

        return redirect()->back()
            ->with('success', 'Product removed from deal successfully.');
    }
}