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
use App\Services\ImageCompressionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    protected $perPageProducts = 20;
    protected $imageCompressor;

    public function __construct(ImageCompressionService $imageCompressor)
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

        $this->imageCompressor = $imageCompressor;
    }

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
            'image_gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // Increased to 5MB max upload
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

            // Save product attributes
            if ($request->filled('product_attributes')) {
                foreach ($request->product_attributes as $index => $attributeData) {
                    if (!empty($attributeData['id']) && !empty($attributeData['values'])) {
                        foreach ($attributeData['values'] as $valueIndex => $value) {
                            if (!empty(trim($value))) {
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
            }

            // Handle gallery images with compression service
            if ($request->hasFile('image_gallery')) {
                $imagePaths = $this->imageCompressor->bulkCompress(
                    $request->file('image_gallery'),
                    [
                        'max_size_kb' => 200,
                        'max_width' => 1200,
                        'max_height' => 1200,
                        'target_ratio' => 4 / 3,
                        'format' => 'jpg',
                        'storage_path' => 'products/gallery',
                        'filename_prefix' => 'prod-' . $product->id,
                        'strip_metadata' => true,
                    ]
                );

                foreach ($imagePaths as $index => $path) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'is_primary' => $index === 0, // First image is primary
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Product created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Product creation failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'Something went wrong while creating the product: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $allDeals = Deal::active()->ordered()->get();
        $product->load(['category', 'brand', 'images', 'attributes']);

        $groupedAttributes = $product->attributes
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
        $groupedAttributes = $product->attributes
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
            'image_gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'specifications' => 'nullable|json',
            'is_active' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean',
            'product_attributes' => 'nullable|array',
            'product_attributes.*.id' => 'required|exists:attributes,id',
            'product_attributes.*.values' => 'required|array',
            'product_attributes.*.values.*' => 'string|max:255',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'exists:product_images,id',
            'primary_image' => 'nullable|exists:product_images,id',
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

            // Handle image removal
            if ($request->has('remove_images') && !empty($request->remove_images)) {
                $this->removeProductImages($product, $request->remove_images);
            }

            // Handle primary image selection
            if ($request->has('primary_image')) {
                $this->updatePrimaryImage($product, $request->primary_image);
            }

            // Handle product attributes
            $this->syncProductAttributes($product, $request->product_attributes ?? []);

            // Handle new gallery images
            if ($request->hasFile('image_gallery')) {
                $this->addNewGalleryImages($product, $request->file('image_gallery'));
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Product updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Product update failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'Something went wrong while updating the product: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            DB::beginTransaction();

            // Soft delete the product
            $product->delete();

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Product moved to trash successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Product deletion failed: ' . $e->getMessage());

            return back()->withErrors(['error' => 'Failed to delete product.']);
        }
    }

    /**
     * Display a listing of soft-deleted products.
     */
    public function trash(Request $request)
    {
        $brands = Brand::where('is_active', true)->get();
        $categories = Category::where('is_active', true)->get();

        $products = Product::onlyTrashed()
            ->with(['category', 'brand'])
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate($this->perPageProducts)
            ->appends($request->all());

        return view('admin.products.trash', compact('brands', 'categories', 'products'));
    }

    /**
     * Restore a soft-deleted product.
     */
    public function restore($id)
    {
        try {
            $product = Product::onlyTrashed()->findOrFail($id);
            $product->restore();

            return redirect()->route('admin.products.trash')
                ->with('success', 'Product restored successfully.');

        } catch (\Exception $e) {
            Log::error('Product restore failed: ' . $e->getMessage());

            return back()->withErrors(['error' => 'Failed to restore product.']);
        }
    }

    /**
     * Bulk delete products
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'selected_products' => 'required|string'
        ]);

        $selectedProducts = json_decode($request->selected_products);

        if (empty($selectedProducts)) {
            return redirect()->back()->with('error', 'No products selected.');
        }

        try {
            Product::whereIn('id', $selectedProducts)->delete();

            return redirect()->route('admin.products.index')
                ->with('success', count($selectedProducts) . ' products moved to trash successfully.');

        } catch (\Exception $e) {
            Log::error('Bulk delete failed: ' . $e->getMessage());

            return back()->withErrors(['error' => 'Failed to delete products.']);
        }
    }

    /**
     * Bulk permanently delete products
     */
    public function bulkForceDelete(Request $request)
    {
        $request->validate([
            'selected_products' => 'required|string'
        ]);

        $selectedProducts = json_decode($request->selected_products);

        if (empty($selectedProducts)) {
            return redirect()->back()->with('error', 'No products selected.');
        }

        try {
            DB::beginTransaction();

            $products = Product::onlyTrashed()->whereIn('id', $selectedProducts)->get();

            foreach ($products as $product) {
                // Delete associated images from storage
                $this->deleteProductImagesFromStorage($product);

                // Force delete the product
                $product->forceDelete();
            }

            DB::commit();

            return redirect()->route('admin.products.trash')
                ->with('success', count($selectedProducts) . ' products permanently deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Bulk force delete failed: ' . $e->getMessage());

            return back()->withErrors(['error' => 'Failed to permanently delete products.']);
        }
    }

    /**
     * Bulk restore products
     */
    public function bulkRestore(Request $request)
    {
        $request->validate([
            'selected_products' => 'required|string'
        ]);

        $selectedProducts = json_decode($request->selected_products);

        if (empty($selectedProducts)) {
            return redirect()->back()->with('error', 'No products selected.');
        }

        try {
            Product::onlyTrashed()->whereIn('id', $selectedProducts)->restore();

            return redirect()->route('admin.products.trash')
                ->with('success', count($selectedProducts) . ' products restored successfully.');

        } catch (\Exception $e) {
            Log::error('Bulk restore failed: ' . $e->getMessage());

            return back()->withErrors(['error' => 'Failed to restore products.']);
        }
    }

    /**
     * Permanently delete a soft-deleted product.
     */
    public function forceDelete($id)
    {
        try {
            DB::beginTransaction();

            $product = Product::onlyTrashed()->findOrFail($id);

            // Delete associated images from storage
            $this->deleteProductImagesFromStorage($product);

            // Force delete the product
            $product->forceDelete();

            DB::commit();

            return redirect()->route('admin.products.trash')
                ->with('success', 'Product permanently deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Force delete failed: ' . $e->getMessage());

            return back()->withErrors(['error' => 'Failed to permanently delete product.']);
        }
    }

    /**
     * Toggle the active status of the product.
     */
    public function toggleStatus(Product $product)
    {
        try {
            $product->update(['is_active' => !$product->is_active]);

            return response()->json([
                'success' => true,
                'message' => 'Product status updated successfully',
                'status' => $product->is_active
            ]);

        } catch (\Exception $e) {
            Log::error('Toggle status failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to update product status'
            ], 500);
        }
    }

    /**
     * Toggle the featured status of the product.
     */
    public function toggleFeatured(Product $product)
    {
        try {
            $product->update(['is_featured' => !$product->is_featured]);

            return response()->json([
                'success' => true,
                'message' => 'Product featured status updated successfully',
                'status' => $product->is_featured
            ]);

        } catch (\Exception $e) {
            Log::error('Toggle featured failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to update featured status'
            ], 500);
        }
    }

    /**
     * Set primary image for the product (API endpoint).
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
            $image = ProductImage::where('id', $request->image_id)
                ->where('product_id', $product->id)
                ->firstOrFail();

            $image->is_primary = true;
            $image->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Primary image updated successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Failed to set primary image: ' . $e->getMessage());

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
        $product->load('deals');

        return view('admin.products.deals', compact('product', 'allDeals'));
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

        try {
            // Sync the deals (replace existing assignments)
            $syncData = [];
            if ($request->has('deal_ids')) {
                foreach ($request->deal_ids as $dealId) {
                    $syncData[$dealId] = ['is_featured' => false];
                }
            }

            $product->deals()->sync($syncData);

            return redirect()->back()
                ->with('success', 'Deal assignments updated successfully.');

        } catch (\Exception $e) {
            Log::error('Assign deals failed: ' . $e->getMessage());

            return back()->withErrors(['error' => 'Failed to assign deals.']);
        }
    }

    /**
     * Remove a product from a deal.
     */
    public function removeDeal(Product $product, Deal $deal)
    {
        try {
            $product->deals()->detach($deal->id);

            return redirect()->back()
                ->with('success', 'Product removed from deal successfully.');

        } catch (\Exception $e) {
            Log::error('Remove deal failed: ' . $e->getMessage());

            return back()->withErrors(['error' => 'Failed to remove product from deal.']);
        }
    }

    /**
     * Generate description using AI (placeholder)
     */
    public function generateDescription(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string'
        ]);

        // This is a placeholder. Implement your AI description generation here
        $description = "This is a generated description for " . $request->product_name .
            ". It includes all the key features and benefits of the product.";

        return response()->json([
            'description' => $description
        ]);
    }

    /**
     * Private helper methods
     */

    /**
     * Remove product images
     */
    private function removeProductImages(Product $product, array $imageIds): void
    {
        $imagesToRemove = ProductImage::whereIn('id', $imageIds)
            ->where('product_id', $product->id)
            ->get();

        foreach ($imagesToRemove as $image) {
            // Delete file from storage
            $fullPath = storage_path('app/public/' . $image->image_path);
            if (file_exists($fullPath) && is_file($fullPath)) {
                unlink($fullPath);
            }

            // Delete database record
            $image->delete();
        }
    }

    /**
     * Update primary image (renamed from setPrimaryImage to avoid conflict)
     */
    private function updatePrimaryImage(Product $product, int $imageId): void
    {
        // Remove primary flag from all images
        ProductImage::where('product_id', $product->id)
            ->update(['is_primary' => false]);

        // Set new primary image
        ProductImage::where('id', $imageId)
            ->where('product_id', $product->id)
            ->update(['is_primary' => true]);
    }

    /**
     * Sync product attributes
     */
    private function syncProductAttributes(Product $product, array $attributes): void
    {
        // Remove all old attributes
        ProductAttribute::where('product_id', $product->id)->delete();

        if (!empty($attributes)) {
            foreach ($attributes as $order => $attributeData) {
                $attrId = $attributeData['id'] ?? null;
                $values = $attributeData['values'] ?? [];

                if ($attrId && !empty($values)) {
                    foreach ($values as $valueIndex => $value) {
                        if (!empty(trim($value))) {
                            ProductAttribute::create([
                                'product_id' => $product->id,
                                'attribute_id' => (int) $attrId,
                                'value' => trim($value),
                                'order' => $valueIndex,
                            ]);
                        }
                    }
                }
            }
        }
    }

    /**
     * Add new gallery images
     */
    private function addNewGalleryImages(Product $product, array $images): void
    {
        // Check if there are no remaining images, set first new image as primary
        $remainingImagesCount = ProductImage::where('product_id', $product->id)->count();
        $setPrimary = $remainingImagesCount === 0;

        $imagePaths = $this->imageCompressor->bulkCompress(
            $images,
            [
                'max_size_kb' => 200,
                'max_width' => 1200,
                'max_height' => 1200,
                'target_ratio' => 4 / 3,
                'format' => 'jpg',
                'storage_path' => 'products/gallery',
                'filename_prefix' => 'prod-' . $product->id,
                'strip_metadata' => true,
            ]
        );

        foreach ($imagePaths as $index => $path) {
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $path,
                'is_primary' => $setPrimary && $index === 0,
            ]);
        }
    }

    /**
     * Delete all product images from storage
     */
    private function deleteProductImagesFromStorage(Product $product): void
    {
        foreach ($product->images as $image) {
            $fullPath = storage_path('app/public/' . $image->image_path);
            if (file_exists($fullPath) && is_file($fullPath)) {
                unlink($fullPath);
            }
        }
    }
}