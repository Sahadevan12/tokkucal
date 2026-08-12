<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;

class ImageCompressionService
{
    /**
     * Compress an uploaded image and return it as an in-memory data URI.
     * Nothing is written to disk — the file is processed entirely in memory
     * and never persisted, temporarily or otherwise.
     *
     * @return array{data_uri: string, mime: string, original_size: int, compressed_size: int, percent_saved: float, width: int, height: int}
     */
    public function compress(UploadedFile $file, int $quality): array
    {
        $manager = ImageManager::gd();
        $image = $manager->read($file->getRealPath())->orient();

        $mime = $file->getMimeType() ?? 'image/jpeg';

        $encoded = match (true) {
            str_contains($mime, 'png') => $image->encode(new PngEncoder(indexed: $quality < 50)),
            str_contains($mime, 'webp') => $image->encode(new WebpEncoder(quality: $quality, strip: true)),
            default => $image->encode(new JpegEncoder(quality: $quality, strip: true)),
        };

        $originalSize = $file->getSize();
        $compressedSize = $encoded->size();

        // Never hand back a "compressed" file that is larger than the original.
        if ($originalSize > 0 && $compressedSize >= $originalSize) {
            return [
                'data_uri' => 'data:'.$mime.';base64,'.base64_encode((string) file_get_contents($file->getRealPath())),
                'mime' => $mime,
                'original_size' => $originalSize,
                'compressed_size' => $originalSize,
                'percent_saved' => 0.0,
                'width' => $image->width(),
                'height' => $image->height(),
            ];
        }

        return [
            'data_uri' => $encoded->toDataUri(),
            'mime' => $encoded->mediaType(),
            'original_size' => $originalSize,
            'compressed_size' => $compressedSize,
            'percent_saved' => $originalSize > 0 ? round((1 - $compressedSize / $originalSize) * 100, 1) : 0.0,
            'width' => $image->width(),
            'height' => $image->height(),
        ];
    }
}
