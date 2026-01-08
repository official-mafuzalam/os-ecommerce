<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:categories_manage')->only([
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
            'bulkRestore'
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('parent')->latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentCategories = Category::whereNull('parent_id')->where('is_active', true)->get();
        $category = new Category();
        return view('admin.categories.create', compact('parentCategories', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            // Allow up to 2 MB on upload; we'll compress to <= 200 KB after upload
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        // Generate slug from name
        $validated['slug'] = Str::slug($validated['name']);

        // Handle image upload and compress to <= 200 KB when possible
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $mime = $file->getMimeType();

            if ($mime === 'image/svg+xml') {
                $validated['image'] = $file->store('categories', 'public');
            } else {
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $filename = Str::slug($originalName) . '-' . time() . '.jpg';
                $publicDir = storage_path('app/public/categories');
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

                    $validated['image'] = 'categories/' . $filename;
                } catch (\Exception $e) {
                    // fallback
                    $validated['image'] = $file->store('categories', 'public');
                }
            }
        }

        // Set default active status if not provided
        $validated['is_active'] = $request->has('is_active');

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->load(['parent', 'children', 'products']);
        $products = $category->products()
            ->with(['brand', 'images'])
            ->latest()
            ->paginate(10);
        
        return view('admin.categories.show', compact('category', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $parentCategories = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->where('is_active', true)
            ->get();

        return view('admin.categories.create', compact('category', 'parentCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            // Allow up to 2 MB on upload; we'll compress to <= 200 KB after upload
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        // Generate slug from name
        $validated['slug'] = Str::slug($validated['name']);

        // Handle image upload and compress to <= 200 KB when possible
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $mime = $file->getMimeType();

            if ($mime === 'image/svg+xml') {
                // store svg as-is
                $newPath = $file->store('categories', 'public');
                if ($category->image) {
                    Storage::disk('public')->delete($category->image);
                }
                $validated['image'] = $newPath;
            } else {
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $filename = Str::slug($originalName) . '-' . time() . '.jpg';
                $publicDir = storage_path('app/public/categories');
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

                    // delete old image only after new one successfully created
                    if ($category->image) {
                        Storage::disk('public')->delete($category->image);
                    }

                    $validated['image'] = 'categories/' . $filename;
                } catch (\Exception $e) {
                    // fallback
                    $validated['image'] = $file->store('categories', 'public');
                }
            }
        }

        // Set active status
        $validated['is_active'] = $request->has('is_active');

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Check if category has products
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Cannot delete category with associated products.');
        }

        // Check if category has children
        if ($category->children()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Cannot delete category with subcategories.');
        }

        // Delete associated image
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
    /**
     * Display a listing of soft-deleted categories.
     */
    public function trash()
    {
        // Get soft-deleted categories with parent relation
        $categories = Category::onlyTrashed()->with('parent')->latest()->paginate(10);

        return view('admin.categories.trash', compact('categories'));
    }

    /**
     * Restore a soft-deleted category.
     */
    public function restore($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);

        $category->restore();

        return redirect()->route('admin.categories.trash')
            ->with('success', 'Category restored successfully.');
    }

    /**
     * Permanently delete a soft-deleted category.
     */
    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);

        // Optional: delete related data if needed (like images)
        $category->forceDelete();

        return redirect()->route('admin.categories.trash')
            ->with('success', 'Category permanently deleted.');
    }

}