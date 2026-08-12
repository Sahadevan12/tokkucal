<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;

class ImageResizeService
{
    /**
     * Resize an uploaded image and return it as an in-memory data URI.
     * Nothing is written to disk.
     *
     * @return array{data_uri: string, mime: string, original_size: int, output_size: int, width: int, height: int}
     */
    public function resize(
        UploadedFile $file,
        ?int $width,
        ?int $height,
        bool $maintainAspectRatio,
        string $outputFormat,
    ): array {
        $manager = ImageManager::gd();
        $image = $manager->read($file->getRealPath())->orient();

        if ($maintainAspectRatio) {
            $image->scale($width, $height);
        } else {
            $image->resize($width, $height);
        }

        $encoded = match ($outputFormat) {
            'png' => $image->encode(new PngEncoder),
            'webp' => $image->encode(new WebpEncoder(quality: 90, strip: true)),
            default => $image->encode(new JpegEncoder(quality: 90, strip: true)),
        };

        return [
            'data_uri' => $encoded->toDataUri(),
            'mime' => $encoded->mediaType(),
            'original_size' => $file->getSize(),
            'output_size' => $encoded->size(),
            'width' => $image->width(),
            'height' => $image->height(),
        ];
    }
}
