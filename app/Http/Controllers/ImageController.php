<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ResolvesTool;
use App\Http\Requests\ImageCompressRequest;
use App\Http\Requests\ImageResizeRequest;
use App\Services\ImageCompressionService;
use App\Services\ImageResizeService;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ImageController extends Controller
{
    use ResolvesTool;

    public function compressor(): View
    {
        $tool = $this->tool('image-compressor');

        return view('tools.image-compressor', [
            ...$this->seoFor($tool),
            'tool' => $tool,
            'jsonLd' => $this->jsonLdFor($tool),
            'breadcrumbs' => $this->breadcrumbsFor($tool),
        ]);
    }

    public function compress(ImageCompressRequest $request, ImageCompressionService $service): JsonResponse
    {
        $result = $service->compress($request->file('image'), (int) $request->validated('quality'));

        return response()->json($result);
    }

    public function resizer(): View
    {
        $tool = $this->tool('image-resizer');

        return view('tools.image-resizer', [
            ...$this->seoFor($tool),
            'tool' => $tool,
            'jsonLd' => $this->jsonLdFor($tool),
            'breadcrumbs' => $this->breadcrumbsFor($tool),
        ]);
    }

    public function resize(ImageResizeRequest $request, ImageResizeService $service): JsonResponse
    {
        $data = $request->validated();

        $result = $service->resize(
            $request->file('image'),
            isset($data['width']) ? (int) $data['width'] : null,
            isset($data['height']) ? (int) $data['height'] : null,
            filter_var($data['maintain_aspect_ratio'] ?? false, FILTER_VALIDATE_BOOLEAN),
            $data['output_format'],
        );

        return response()->json($result);
    }
}
