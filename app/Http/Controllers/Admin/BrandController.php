<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:brands_manage')->only([
            'index',
            'create',
            'store',
            'edit',
            'update',
            'destroy',
            'trash',
            'restore',
            'forceDelete'
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::latest()->paginate(10);
        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brand = new Brand();
        return view('admin.brands.create', compact('brand'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name',
            'description' => 'nullable|string',
            // Allow up to 2 MB on upload; we'll compress to <= 200 KB after upload
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'boolean'
        ]);

        // Generate slug from name
        $validated['slug'] = Str::slug($validated['name']);

        // Handle logo upload and compress to <= 200 KB when possible
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $mime = $file->getMimeType();

            // If SVG, just store it (GD can't process SVG)
            if ($mime === 'image/svg+xml') {
                $validated['logo'] = $file->store('brands', 'public');
            } else {
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $filename = Str::slug($originalName) . '-' . time() . '.jpg';
                $publicDir = storage_path('app/public/brands');
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

                        if ($newW < 150 || $newH < 150) {
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

                    $validated['logo'] = 'brands/' . $filename;
                } catch (\Exception $e) {
                    // fallback
                    $validated['logo'] = $file->store('brands', 'public');
                }
            }
        }

        // Set default active status if not provided
        $validated['is_active'] = $request->has('is_active');

        Brand::create($validated);

        return redirect()->route('admin.brands.index')
            ->with('success', 'Brand created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        // Load product count
        $brand->loadCount('products');

        // Get paginated products with relationships
        $products = $brand->products()
            ->with(['category', 'images'])
            ->latest()
            ->paginate(10);

        // Get additional statistics
        $activeProductsCount = $brand->products()->where('is_active', true)->count();
        $outOfStockCount = $brand->products()->where('stock_quantity', '<=', 0)->count();

        return view('admin.brands.show', compact('brand', 'products', 'activeProductsCount', 'outOfStockCount'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return view('admin.brands.create', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $brand->id,
            'description' => 'nullable|string',
            // Allow up to 2 MB on upload; we'll compress to <= 200 KB after upload
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'boolean'
        ]);

        // Generate slug from name
        $validated['slug'] = Str::slug($validated['name']);

        // Handle logo upload and compress to <= 200 KB when possible
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $mime = $file->getMimeType();

            if ($mime === 'image/svg+xml') {
                // store svg as-is
                $newPath = $file->store('brands', 'public');
                // delete old after new stored
                if ($brand->logo) {
                    Storage::disk('public')->delete($brand->logo);
                }
                $validated['logo'] = $newPath;
            } else {
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $filename = Str::slug($originalName) . '-' . time() . '.jpg';
                $publicDir = storage_path('app/public/brands');
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

                        if ($newW < 150 || $newH < 150) {
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

                    // delete old logo only after new one successfully created
                    if ($brand->logo) {
                        Storage::disk('public')->delete($brand->logo);
                    }

                    $validated['logo'] = 'brands/' . $filename;
                } catch (\Exception $e) {
                    // fallback
                    $validated['logo'] = $file->store('brands', 'public');
                }
            }
        }

        // Set active status
        $validated['is_active'] = $request->has('is_active');

        $brand->update($validated);

        return redirect()->route('admin.brands.index')
            ->with('success', 'Brand updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        // Check if brand has products
        if ($brand->products()->count() > 0) {
            return redirect()->route('admin.brands.index')
                ->with('error', 'Cannot delete brand with associated products.');
        }

        // Delete associated logo
        if ($brand->logo) {
            Storage::disk('public')->delete($brand->logo);
        }

        $brand->delete();

        return redirect()->route('admin.brands.index')
            ->with('success', 'Brand deleted successfully.');
    }


    /**
     * Display a listing of soft-deleted brands.
     */
    public function trash()
    {
        $brands = Brand::onlyTrashed()->latest()->paginate(10);
        return view('admin.brands.trash', compact('brands'));
    }

    /**
     * Restore a soft-deleted brand.
     */
    public function restore($id)
    {
        $brand = Brand::onlyTrashed()->findOrFail($id);
        $brand->restore();

        return redirect()->route('admin.brands.trash')
            ->with('success', 'Brand restored successfully.');
    }

    /**
     * Permanently delete a soft-deleted brand.
     */
    public function forceDelete($id)
    {
        $brand = Brand::onlyTrashed()->findOrFail($id);

        // Optional: delete related images if needed
        if ($brand->logo && Storage::disk('public')->exists($brand->logo)) {
            Storage::disk('public')->delete($brand->logo);
        }

        $brand->forceDelete();

        return redirect()->route('admin.brands.trash')
            ->with('success', 'Brand permanently deleted.');
    }
}