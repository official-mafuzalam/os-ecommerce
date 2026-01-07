<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CarouselController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:settings_manage')->only([
            'index',
            'create',
            'store',
            'edit',
            'update',
            'destroy',
            'reorder'
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carousels = Carousel::ordered()->get();
        return view('admin.carousels.index', compact('carousels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.carousels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            // Allow up to 1 MB on upload, we'll compress to <= 600 KB after upload
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'button_text' => 'nullable|string|max:50',
            'button_url' => 'nullable|url|max:255',
            'secondary_button_text' => 'nullable|string|max:50',
            'secondary_button_url' => 'nullable|url|max:255',
            'background_color' => 'nullable|string|max:100',
            'order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $filename = Str::slug($originalName) . '-' . time() . '.jpg';
            $publicDir = storage_path('app/public/carousels');
            $targetPath = $publicDir . DIRECTORY_SEPARATOR . $filename;

            if (!file_exists($publicDir)) {
                mkdir($publicDir, 0755, true);
            }

            try {
                $mime = $file->getMimeType();

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

                $width = imagesx($src);
                $height = imagesy($src);

                // ensure true color and white background for transparency
                $dst = imagecreatetruecolor($width, $height);
                $white = imagecolorallocate($dst, 255, 255, 255);
                imagefill($dst, 0, 0, $white);
                imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $width, $height);

                // save initially as jpeg
                $quality = 85;
                imagejpeg($dst, $targetPath, $quality);

                imagedestroy($src);
                imagedestroy($dst);

                $maxBytes = 400 * 1024; // 400 KB

                // Reduce quality iteratively if still too large
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

                // If still too large, resize gradually until under target or until small enough
                while (filesize($targetPath) > $maxBytes) {
                    $src = imagecreatefromjpeg($targetPath);
                    $w = imagesx($src);
                    $h = imagesy($src);
                    $newW = (int)($w * 0.9);
                    $newH = (int)($h * 0.9);

                    // don't shrink below reasonable limits
                    if ($newW < 200 || $newH < 200) {
                        imagedestroy($src);
                        break;
                    }

                    $dst = imagecreatetruecolor($newW, $newH);
                    $white = imagecolorallocate($dst, 255, 255, 255);
                    imagefill($dst, 0, 0, $white);
                    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newW, $newH, $w, $h);
                    imagejpeg($dst, $targetPath, $quality);
                    imagedestroy($src);
                    imagedestroy($dst);
                }

                // final stored path relative to public disk
                $validated['image'] = 'carousels/' . $filename;
            } catch (\Exception $e) {
                // fallback to storing the original file if processing fails
                $validated['image'] = $file->store('carousels', 'public');
            }
        }

        Carousel::create($validated);

        return redirect()->route('admin.carousels.index')
            ->with('success', 'Carousel item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Carousel $carousel)
    {
        return view('admin.carousels.edit', compact('carousel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Carousel $carousel)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'button_text' => 'nullable|string|max:50',
            'button_url' => 'nullable|url|max:255',
            'secondary_button_text' => 'nullable|string|max:50',
            'secondary_button_url' => 'nullable|url|max:255',
            'background_color' => 'nullable|string|max:100',
            'order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $filename = Str::slug($originalName) . '-' . time() . '.jpg';
            $publicDir = storage_path('app/public/carousels');
            $targetPath = $publicDir . DIRECTORY_SEPARATOR . $filename;

            if (!file_exists($publicDir)) {
                mkdir($publicDir, 0755, true);
            }

            try {
                $mime = $file->getMimeType();

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

                $width = imagesx($src);
                $height = imagesy($src);

                $dst = imagecreatetruecolor($width, $height);
                $white = imagecolorallocate($dst, 255, 255, 255);
                imagefill($dst, 0, 0, $white);
                imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $width, $height);

                $quality = 85;
                imagejpeg($dst, $targetPath, $quality);

                imagedestroy($src);
                imagedestroy($dst);

                $maxBytes = 400 * 1024; // 400 KB

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
                    $w = imagesx($src);
                    $h = imagesy($src);
                    $newW = (int)($w * 0.9);
                    $newH = (int)($h * 0.9);

                    if ($newW < 200 || $newH < 200) {
                        imagedestroy($src);
                        break;
                    }

                    $dst = imagecreatetruecolor($newW, $newH);
                    $white = imagecolorallocate($dst, 255, 255, 255);
                    imagefill($dst, 0, 0, $white);
                    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newW, $newH, $w, $h);
                    imagejpeg($dst, $targetPath, $quality);
                    imagedestroy($src);
                    imagedestroy($dst);
                }

                // delete old image only after new one successfully created
                if ($carousel->image) {
                    Storage::disk('public')->delete($carousel->image);
                }

                $validated['image'] = 'carousels/' . $filename;
            } catch (\Exception $e) {
                // fallback: store original
                $validated['image'] = $file->store('carousels', 'public');
            }
        }

        $carousel->update($validated);

        return redirect()->route('admin.carousels.index')
            ->with('success', 'Carousel item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Carousel $carousel)
    {
        // Delete image
        if ($carousel->image) {
            Storage::disk('public')->delete($carousel->image);
        }

        $carousel->delete();

        return redirect()->route('admin.carousels.index')
            ->with('success', 'Carousel item deleted successfully.');
    }

    public function reorder(Request $request)
    {
        $order = $request->input('order');

        foreach ($order as $index => $id) {
            Carousel::where('id', $id)->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
