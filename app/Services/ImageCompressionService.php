<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Exception;

class ImageCompressionService
{
    /**
     * Check if GD is available
     */
    private function isGDAvailable(): bool
    {
        return extension_loaded('gd') && function_exists('gd_info');
    }

    /**
     * Compress and store an image with configurable parameters
     *
     * @param UploadedFile $image
     * @param array $options Compression options
     * @return string Path to stored image
     * @throws Exception
     */
    public function compress(UploadedFile $image, array $options = []): string
    {
        // Default configuration
        $config = array_merge([
            'max_size_kb' => 200,           // Maximum file size in KB
            'max_width' => 1080,             // Maximum width in pixels
            'max_height' => 1080,             // Maximum height in pixels
            'maintain_aspect_ratio' => true,  // Maintain aspect ratio when resizing
            'quality' => 85,                   // Initial JPEG quality (0-100)
            'min_quality' => 30,                // Minimum JPEG quality
            'format' => 'jpg',                   // Output format: jpg, png, webp
            'strip_metadata' => true,             // Remove EXIF metadata
            'crop' => false,                       // Crop to exact dimensions
            'crop_x' => null,                       // Crop X position
            'crop_y' => null,                        // Crop Y position
            'crop_width' => null,                     // Crop width
            'crop_height' => null,                     // Crop height
            'target_ratio' => null,                    // Target aspect ratio (e.g., 4/3, 16/9)
            'storage_path' => 'products/gallery',      // Storage path
            'filename_prefix' => '',                    // Prefix for filename
            'filename_suffix' => '',                    // Suffix for filename
            'disk' => 'public',                         // Storage disk
        ], $options);

        // Validate image
        $this->validateImage($image);

        // Generate filename
        $filename = $this->generateFilename($image, $config);

        // Full storage path
        $fullPath = $config['storage_path'] . '/' . $filename;

        // Try Intervention Image first (if available)
        if (class_exists('Intervention\Image\Facades\Image')) {
            try {
                return $this->compressWithIntervention($image, $fullPath, $config);
            } catch (Exception $e) {
                // Log the error and fall back to GD
                logger()->warning('Intervention Image failed, falling back to GD: ' . $e->getMessage());
            }
        }

        // Fall back to GD
        if ($this->isGDAvailable()) {
            return $this->compressWithGD($image, $fullPath, $config);
        }

        // If neither is available, just store the original
        logger()->warning('No image compression library available, storing original image');
        return $this->storeOriginal($image, $fullPath, $config);
    }

    /**
     * Store original image without compression
     */
    private function storeOriginal(UploadedFile $image, string $fullPath, array $config): string
    {
        $disk = Storage::disk($config['disk']);

        // Store the original file
        $path = $disk->putFileAs(
            dirname($fullPath),
            $image,
            basename($fullPath)
        );

        return $path;
    }

    /**
     * Compress image using Intervention Image
     */
    private function compressWithIntervention(UploadedFile $image, string $fullPath, array $config): string
    {
        $disk = Storage::disk($config['disk']);
        $targetPath = $disk->path($fullPath);

        // Ensure directory exists
        $directory = dirname($targetPath);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        // Load image
        $interventionImage = Image::make($image);

        // Strip metadata
        if ($config['strip_metadata']) {
            $interventionImage->strip();
        }

        // Apply target ratio if specified
        if ($config['target_ratio']) {
            $interventionImage->resize($config['max_width'], $config['max_height'], function ($constraint) use ($config) {
                if ($config['maintain_aspect_ratio']) {
                    $constraint->aspectRatio();
                }
                $constraint->upsize();
            });

            // Calculate and apply ratio crop
            $currentRatio = $interventionImage->width() / $interventionImage->height();
            $targetRatio = $config['target_ratio'];

            if (abs($currentRatio - $targetRatio) > 0.01) {
                if ($currentRatio > $targetRatio) {
                    // Too wide - crop width
                    $newWidth = (int) ($interventionImage->height() * $targetRatio);
                    $interventionImage->crop($newWidth, $interventionImage->height(), 0, 0);
                } else {
                    // Too tall - crop height
                    $newHeight = (int) ($interventionImage->width() / $targetRatio);
                    $interventionImage->crop($interventionImage->width(), $newHeight, 0, 0);
                }
            }
        } else {
            // Standard resize
            $interventionImage->resize($config['max_width'], $config['max_height'], function ($constraint) use ($config) {
                if ($config['maintain_aspect_ratio']) {
                    $constraint->aspectRatio();
                }
                $constraint->upsize();
            });
        }

        // Apply crop if specified
        if ($config['crop'] && $config['crop_width'] && $config['crop_height']) {
            $cropX = $config['crop_x'] ?? 0;
            $cropY = $config['crop_y'] ?? 0;
            $cropWidth = $config['crop_width'];
            $cropHeight = $config['crop_height'];
            $interventionImage->crop($cropWidth, $cropHeight, $cropX, $cropY);
        }

        // Save with appropriate quality
        switch ($config['format']) {
            case 'png':
                $interventionImage->save($targetPath, 9); // PNG compression level 0-9
                break;
            case 'webp':
                $interventionImage->encode('webp', $config['quality'])->save($targetPath);
                break;
            default:
                $interventionImage->save($targetPath, $config['quality']);
        }

        // Compress to target file size if needed
        if ($config['max_size_kb'] > 0) {
            $this->compressToTargetSizeWithIntervention($targetPath, $interventionImage, $config);
        }

        return $fullPath;
    }

    /**
     * Compress image using GD library
     */
    private function compressWithGD(UploadedFile $image, string $fullPath, array $config): string
    {
        $disk = Storage::disk($config['disk']);
        $targetPath = $disk->path($fullPath);

        // Ensure directory exists
        $directory = dirname($targetPath);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        $mime = $image->getMimeType();
        $sourcePath = $image->getPathname();

        // Create image resource from source
        $sourceImage = $this->createImageFromSource($sourcePath, $mime);

        if (!$sourceImage) {
            throw new Exception("Unable to create image from source with GD");
        }

        // Get original dimensions
        $origWidth = imagesx($sourceImage);
        $origHeight = imagesy($sourceImage);

        // Calculate new dimensions
        [$newWidth, $newHeight] = $this->calculateDimensions($origWidth, $origHeight, $config);

        // Apply target ratio if specified
        if ($config['target_ratio']) {
            [$newWidth, $newHeight] = $this->applyTargetRatio($origWidth, $origHeight, $config['target_ratio']);
        }

        // Create destination image
        $destinationImage = imagecreatetruecolor($newWidth, $newHeight);

        // Preserve transparency for PNG
        if ($config['format'] === 'png') {
            imagealphablending($destinationImage, false);
            imagesavealpha($destinationImage, true);
            $transparent = imagecolorallocatealpha($destinationImage, 255, 255, 255, 127);
            imagefilledrectangle($destinationImage, 0, 0, $newWidth, $newHeight, $transparent);
        } else {
            // Fill with white background for other formats
            $white = imagecolorallocate($destinationImage, 255, 255, 255);
            imagefill($destinationImage, 0, 0, $white);
        }

        // Apply cropping if requested
        if ($config['crop'] && $config['crop_width'] && $config['crop_height']) {
            $cropX = $config['crop_x'] ?? 0;
            $cropY = $config['crop_y'] ?? 0;
            $cropWidth = min($config['crop_width'], $origWidth);
            $cropHeight = min($config['crop_height'], $origHeight);

            imagecopyresampled(
                $destinationImage,
                $sourceImage,
                0,
                0,
                $cropX,
                $cropY,
                $newWidth,
                $newHeight,
                $cropWidth,
                $cropHeight
            );
        } else {
            // Standard resizing
            imagecopyresampled(
                $destinationImage,
                $sourceImage,
                0,
                0,
                0,
                0,
                $newWidth,
                $newHeight,
                $origWidth,
                $origHeight
            );
        }

        // Save image based on format
        $this->saveImageWithGD($destinationImage, $targetPath, $config);

        // Clean up
        imagedestroy($sourceImage);
        imagedestroy($destinationImage);

        // Compress to target file size if needed
        if ($config['max_size_kb'] > 0) {
            $this->compressToTargetSizeWithGD($targetPath, $config);
        }

        return $fullPath;
    }

    /**
     * Save image with GD
     */
    private function saveImageWithGD($image, string $targetPath, array $config): void
    {
        switch ($config['format']) {
            case 'png':
                imagepng($image, $targetPath, 9);
                break;
            case 'webp':
                if (function_exists('imagewebp')) {
                    imagewebp($image, $targetPath, $config['quality']);
                } else {
                    imagejpeg($image, $targetPath, $config['quality']);
                }
                break;
            case 'gif':
                imagegif($image, $targetPath);
                break;
            default:
                imagejpeg($image, $targetPath, $config['quality']);
        }
    }

    /**
     * Compress to target size with GD
     */
    private function compressToTargetSizeWithGD(string $targetPath, array $config): void
    {
        $maxBytes = $config['max_size_kb'] * 1024;
        $quality = $config['quality'];
        $minQuality = $config['min_quality'];

        // First try reducing quality
        while (file_exists($targetPath) && filesize($targetPath) > $maxBytes && $quality > $minQuality) {
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

        // If still too large, reduce dimensions
        while (file_exists($targetPath) && filesize($targetPath) > $maxBytes) {
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
    }

    /**
     * Compress to target size with Intervention
     */
    private function compressToTargetSizeWithIntervention(string $targetPath, $image, array $config): void
    {
        $maxBytes = $config['max_size_kb'] * 1024;
        $quality = $config['quality'];
        $minQuality = $config['min_quality'];

        // First try reducing quality
        while (file_exists($targetPath) && filesize($targetPath) > $maxBytes && $quality > $minQuality) {
            $quality -= 5;
            $image->save($targetPath, $quality);
        }

        // If still too large, reduce dimensions
        while (file_exists($targetPath) && filesize($targetPath) > $maxBytes) {
            $currentWidth = $image->width();
            $currentHeight = $image->height();

            $newWidth = (int) ($currentWidth * 0.9);
            $newHeight = (int) ($currentHeight * 0.9);

            if ($newWidth < 400 || $newHeight < 400) {
                break;
            }

            $image->resize($newWidth, $newHeight);
            $image->save($targetPath, $quality);
        }
    }

    /**
     * Calculate new dimensions based on constraints
     */
    private function calculateDimensions(int $origWidth, int $origHeight, array $config): array
    {
        $newWidth = $origWidth;
        $newHeight = $origHeight;

        if ($config['maintain_aspect_ratio']) {
            // Resize based on max dimensions while maintaining aspect ratio
            if ($origWidth > $config['max_width']) {
                $ratio = $config['max_width'] / $origWidth;
                $newWidth = $config['max_width'];
                $newHeight = (int) ($origHeight * $ratio);
            }

            if ($newHeight > $config['max_height']) {
                $ratio = $config['max_height'] / $newHeight;
                $newHeight = $config['max_height'];
                $newWidth = (int) ($newWidth * $ratio);
            }
        } else {
            // Force exact dimensions
            $newWidth = min($origWidth, $config['max_width']);
            $newHeight = min($origHeight, $config['max_height']);
        }

        return [$newWidth, $newHeight];
    }

    /**
     * Apply target aspect ratio
     */
    private function applyTargetRatio(int $width, int $height, float $targetRatio): array
    {
        $currentRatio = $width / $height;

        if ($currentRatio > $targetRatio) {
            // Too wide - adjust width to match ratio based on height
            $newWidth = (int) ($height * $targetRatio);
            $newHeight = $height;
        } else {
            // Too tall - adjust height to match ratio based on width
            $newWidth = $width;
            $newHeight = (int) ($width / $targetRatio);
        }

        return [$newWidth, $newHeight];
    }

    /**
     * Create image resource from source
     */
    private function createImageFromSource(string $sourcePath, string $mime)
    {
        switch ($mime) {
            case 'image/jpeg':
            case 'image/jpg':
                return imagecreatefromjpeg($sourcePath);
            case 'image/png':
                return imagecreatefrompng($sourcePath);
            case 'image/gif':
                return imagecreatefromgif($sourcePath);
            case 'image/webp':
                return function_exists('imagecreatefromwebp') ? imagecreatefromwebp($sourcePath) : imagecreatefromjpeg($sourcePath);
            case 'image/bmp':
                return function_exists('imagecreatefrombmp') ? imagecreatefrombmp($sourcePath) : null;
            case 'image/avif':
                return function_exists('imagecreatefromavif') ? imagecreatefromavif($sourcePath) : null;
            default:
                return null;
        }
    }

    /**
     * Generate filename
     */
    private function generateFilename(UploadedFile $image, array $config): string
    {
        $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $timestamp = time();
        $random = Str::random(8);

        $filename = Str::slug($originalName);

        if ($config['filename_prefix']) {
            $filename = $config['filename_prefix'] . '-' . $filename;
        }

        $filename .= '-' . $timestamp . '-' . $random;

        if ($config['filename_suffix']) {
            $filename .= '-' . $config['filename_suffix'];
        }

        return $filename . '.' . $config['format'];
    }

    /**
     * Validate image
     */
    private function validateImage(UploadedFile $image): void
    {
        if (!$image->isValid()) {
            throw new Exception("Invalid image upload");
        }

        $allowedMimes = [
            'image/jpeg',
            'image/jpg',
            'image/png',
            'image/gif',
            'image/webp',
            'image/bmp',
            'image/avif'
        ];

        if (!in_array($image->getMimeType(), $allowedMimes)) {
            throw new Exception("Unsupported image format: " . $image->getMimeType());
        }
    }

    /**
     * Bulk compress multiple images
     *
     * @param array $images Array of UploadedFile objects
     * @param array $options Compression options
     * @return array Array of stored paths
     */
    public function bulkCompress(array $images, array $options = []): array
    {
        $paths = [];

        foreach ($images as $index => $image) {
            if ($image instanceof UploadedFile) {
                $imageOptions = $options;
                $imageOptions['filename_suffix'] = ($options['filename_suffix'] ?? '') . "-{$index}";

                try {
                    $paths[] = $this->compress($image, $imageOptions);
                } catch (Exception $e) {
                    logger()->error("Failed to compress image {$index}: " . $e->getMessage());
                    // Store original as fallback
                    try {
                        $disk = Storage::disk($options['disk'] ?? 'public');
                        $path = $disk->putFile(
                            $options['storage_path'] ?? 'products/gallery',
                            $image
                        );
                        $paths[] = $path;
                    } catch (Exception $e2) {
                        logger()->error("Failed to store original image {$index}: " . $e2->getMessage());
                    }
                }
            }
        }

        return $paths;
    }
}