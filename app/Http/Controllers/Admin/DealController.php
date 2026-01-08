<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deal;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DealController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:deals_manage')->only([
            'index',
            'create',
            'store',
            'edit',
            'update',
            'destroy',
            'toggleStatus',
            'toggleDealFeatured',
            'productsShow',
            'manageProducts',
            'assignProducts',
            'removeProduct',
            'toggleFeatured'
        ]);
    }

    /**
     * Display a listing of the deals.
     */
    public function index()
    {
        $deals = Deal::orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.deals.index', compact('deals'));
    }

    /**
     * Show the form for creating a new deal.
     */
    public function create()
    {
        return view('admin.deals.create');
    }

    /**
     * Store a newly created deal in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_text' => 'nullable|string|max:255',
            'discount_percentage' => 'nullable|integer|min:0|max:100',
            'discount_details' => 'nullable|string|max:255',
            'button_text' => 'required|string|max:50',
            'button_link' => 'required|url',
            // Allow up to 2 MB on upload; we'll compress to <= 200 KB after upload
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'background_color' => 'required|string|max:100',
            'is_active' => 'boolean',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'priority' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Handle image upload and compress to <= 200 KB when possible
        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $mime = $file->getMimeType();

            // If SVG, store as-is (GD can't handle SVG)
            if ($mime === 'image/svg+xml') {
                $imagePath = $file->store('deals', 'public');
            } else {
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $filename = Str::slug($originalName) . '-' . time() . '.jpg';
                $publicDir = storage_path('app/public/deals');
                $targetPath = $publicDir . DIRECTORY_SEPARATOR . $filename;

                if (!file_exists($publicDir)) {
                    mkdir($publicDir, 0755, true);
                }

                try {
                    switch ($mime) {
                        case 'image/png':
                            $src = imagecreatefrompng($file->getPathname());
                            break;
                        case 'image/gif':
                            $src = imagecreatefromgif($file->getPathname());
                            break;
                        default:
                            $src = imagecreatefromjpeg($file->getPathname());
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

                        if ($newW < 200 || $newH < 200) {
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

                    $imagePath = 'deals/' . $filename;
                } catch (\Exception $e) {
                    // fallback to storing original file
                    $imagePath = $file->store('deals', 'public');
                }
            }
        }

        $deal = Deal::create([
            'title' => $request->title,
            'description' => $request->description,
            'discount_text' => $request->discount_text,
            'discount_percentage' => $request->discount_percentage,
            'discount_details' => $request->discount_details,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'image_url' => $imagePath ? Storage::url($imagePath) : null,
            'background_color' => $request->background_color,
            'is_active' => $request->has('is_active'),
            'starts_at' => $request->starts_at,
            'ends_at' => $request->ends_at,
            'priority' => $request->priority,
        ]);

        return redirect()->route('admin.deals.index')
            ->with('success', 'Deal created successfully.');
    }

    /**
     * Display the specified deal.
     */
    public function show(Deal $deal)
    {
        // Load products with their images and pivot data
        $deal->load([
            'products' => function ($query) {
                $query->with(['images', 'category'])
                    ->orderBy('deal_product.order');
            },
            'featuredProducts'
        ]);

        return view('admin.deals.show', compact('deal'));
    }

    /**
     * Show the form for editing the specified deal.
     */
    public function edit(Deal $deal)
    {
        return view('admin.deals.edit', compact('deal'));
    }

    /**
     * Update the specified deal in storage.
     */
    public function update(Request $request, Deal $deal)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_text' => 'nullable|string|max:255',
            'discount_percentage' => 'nullable|integer|min:0|max:100',
            'discount_details' => 'nullable|string|max:255',
            'button_text' => 'required|string|max:50',
            'button_link' => 'required|url',
            // Allow up to 2 MB on upload; we'll compress to <= 200 KB after upload
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'background_color' => 'required|string|max:100',
            'is_active' => 'boolean',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'priority' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Handle image upload if a new image is provided (compress to <= 200 KB when possible)
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $mime = $file->getMimeType();

            if ($mime === 'image/svg+xml') {
                $newPath = $file->store('deals', 'public');
                // delete old after new stored
                if ($deal->image_url) {
                    $oldImagePath = str_replace('/storage/', '', $deal->image_url);
                    Storage::disk('public')->delete($oldImagePath);
                }
                $deal->image_url = Storage::url($newPath);
            } else {
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $filename = Str::slug($originalName) . '-' . time() . '.jpg';
                $publicDir = storage_path('app/public/deals');
                $targetPath = $publicDir . DIRECTORY_SEPARATOR . $filename;

                if (!file_exists($publicDir)) {
                    mkdir($publicDir, 0755, true);
                }

                try {
                    switch ($mime) {
                        case 'image/png':
                            $src = imagecreatefrompng($file->getPathname());
                            break;
                        case 'image/gif':
                            $src = imagecreatefromgif($file->getPathname());
                            break;
                        default:
                            $src = imagecreatefromjpeg($file->getPathname());
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

                        if ($newW < 200 || $newH < 200) {
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

                    // delete old image only after new one successfully created
                    if ($deal->image_url) {
                        $oldImagePath = str_replace('/storage/', '', $deal->image_url);
                        Storage::disk('public')->delete($oldImagePath);
                    }

                    $deal->image_url = Storage::url('deals/' . $filename);
                } catch (\Exception $e) {
                    // fallback: store original
                    $imagePath = $file->store('deals', 'public');
                    if ($deal->image_url) {
                        $oldImagePath = str_replace('/storage/', '', $deal->image_url);
                        Storage::disk('public')->delete($oldImagePath);
                    }
                    $deal->image_url = Storage::url($imagePath);
                }
            }
        }

        $deal->update([
            'title' => $request->title,
            'description' => $request->description,
            'discount_text' => $request->discount_text,
            'discount_percentage' => $request->discount_percentage,
            'discount_details' => $request->discount_details,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'background_color' => $request->background_color,
            'is_active' => $request->has('is_active'),
            'starts_at' => $request->starts_at,
            'ends_at' => $request->ends_at,
            'priority' => $request->priority,
        ]);

        return redirect()->route('admin.deals.index')
            ->with('success', 'Deal updated successfully.');
    }

    /**
     * Remove the specified deal from storage.
     */
    public function destroy(Deal $deal)
    {
        // Delete associated image
        if ($deal->image_url) {
            $imagePath = str_replace('/storage/', '', $deal->image_url);
            Storage::disk('public')->delete($imagePath);
        }

        $deal->delete();

        return redirect()->route('admin.deals.index')
            ->with('success', 'Deal deleted successfully.');
    }

    /**
     * Toggle the active status of a deal.
     */
    public function toggleStatus(Deal $deal)
    {
        $deal->is_active = !$deal->is_active;
        $deal->save();

        return redirect()->back()
            ->with('success', 'Deal status updated successfully.');
    }

    /**
     * Toggle the featured status of a deal.
     */
    public function toggleDealFeatured(Deal $deal)
    {
        $deal->is_featured = !$deal->is_featured;
        $deal->save();

        return redirect()->back()
            ->with('success', 'Deal featured status updated successfully.');
    }

    /**
     * Display products associated with a specific deal.
     */
    public function productsShow(Deal $deal)
    {
        $allProducts = $deal->products()->paginate(20);
        return view('admin.deals.products', compact('deal', 'allProducts'));
    }

    /**
     * Show form to manage products for a deal.
     */
    public function manageProducts(Deal $deal)
    {
        $allProducts = Product::active()->orderBy('name')->get();

        return view('admin.deals.products', compact('deal', 'allProducts'));
    }

    /**
     * Assign products to a deal.
     */
    public function assignProducts(Request $request, Deal $deal)
    {
        $request->validate([
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:products,id',
        ]);

        // Get current product count to set order for new products
        $currentCount = $deal->products()->count();
        $syncData = [];

        foreach ($request->product_ids as $index => $productId) {
            $syncData[$productId] = [
                'order' => $currentCount + $index,
                'is_featured' => false
            ];
        }

        // Attach new products without detaching existing ones
        $deal->products()->syncWithoutDetaching($syncData);

        return redirect()->back()
            ->with('success', 'Products added to deal successfully.');
    }

    /**
     * Remove a product from a deal.
     */
    public function removeProduct(Deal $deal, Product $product)
    {
        $deal->products()->detach($product->id);

        return redirect()->back()
            ->with('success', 'Product removed from deal successfully.');
    }

    /**
     * Toggle featured status for a product in a deal.
     */
    public function toggleFeatured(Deal $deal, Product $product)
    {
        $isFeatured = !$deal->products()->where('product_id', $product->id)->first()->pivot->is_featured;

        $deal->products()->updateExistingPivot($product->id, ['is_featured' => $isFeatured]);

        return redirect()->back()
            ->with('success', 'Featured status updated successfully.');
    }
}