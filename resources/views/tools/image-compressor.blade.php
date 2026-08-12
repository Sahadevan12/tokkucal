@extends('layouts.app')

@section('content')
<div class="container-page py-8 sm:py-10">
    <x-breadcrumbs :items="$breadcrumbs" />

    <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Image Compressor</h1>
    <p class="mt-3 max-w-2xl text-slate-600">{{ $tool->description }}</p>

    <div class="mt-8 grid gap-8 lg:grid-cols-3 lg:items-start">
        <div class="space-y-6 lg:col-span-2">
            <div class="card p-6 sm:p-8">
                <div
                    id="compressor-dropzone"
                    data-action="{{ route('image-compressor.process') }}"
                    class="flex min-h-48 cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-slate-300 bg-slate-50 p-6 text-center transition hover:border-indigo-400"
                    role="button"
                    tabindex="0"
                    aria-label="Choose an image to compress"
                >
                    <x-icon name="upload" class="h-8 w-8 text-slate-400" />
                    <p class="mt-3 text-sm font-medium text-slate-700">Drag and drop an image here, or tap to choose a file</p>
                    <p class="mt-1 text-xs text-slate-500">JPG, PNG or WebP — up to 10MB</p>
                    <input type="file" id="compressor-file-input" accept="image/jpeg,image/png,image/webp" class="sr-only">
                </div>
                <p id="compressor-file-error" class="field-error hidden" role="alert"></p>

                <div id="compressor-controls" class="mt-6 hidden">
                    <div class="flex items-center gap-4">
                        <img id="compressor-preview" src="" alt="Selected image preview" class="h-20 w-20 shrink-0 rounded-xl border border-slate-200 object-cover">
                        <div class="min-w-0">
                            <p id="compressor-filename" class="truncate text-sm font-medium text-slate-900"></p>
                            <p id="compressor-original-size" class="text-sm text-slate-500"></p>
                        </div>
                    </div>

                    <div class="mt-5">
                        <label for="compressor-quality" class="field-label">Compression Quality: <span id="compressor-quality-value">80</span></label>
                        <input type="range" id="compressor-quality" min="10" max="100" value="80" class="w-full accent-indigo-600">
                        <p class="field-help">Lower quality means a smaller file size but more visible compression.</p>
                    </div>

                    <div class="mt-5 flex flex-wrap gap-3">
                        <button type="button" id="compressor-compress-btn" class="btn-primary">Compress Image</button>
                        <button type="button" id="compressor-reset-btn" class="btn-secondary">
                            <x-icon name="reset" class="h-4 w-4" /> Reset
                        </button>
                    </div>
                </div>
            </div>

            <div id="compressor-result" class="card hidden p-6 sm:p-8" aria-live="polite">
                <h2 class="text-lg font-bold text-slate-900">Result</h2>
                <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div class="rounded-xl bg-slate-50 p-4">
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Original Size</p>
                        <p class="mt-1 text-lg font-bold text-slate-900" id="compressor-result-original">—</p>
                    </div>
                    <div class="rounded-xl bg-slate-50 p-4">
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Compressed Size</p>
                        <p class="mt-1 text-lg font-bold text-slate-900" id="compressor-result-compressed">—</p>
                    </div>
                    <div class="rounded-xl bg-emerald-50 p-4">
                        <p class="text-xs font-medium uppercase tracking-wide text-emerald-600">Saved</p>
                        <p class="mt-1 text-lg font-bold text-emerald-700" id="compressor-result-saved">—</p>
                    </div>
                </div>
                <a id="compressor-download-btn" href="#" download class="btn-primary mt-5 w-full sm:w-auto">
                    <x-icon name="download" class="h-4 w-4" /> Download Compressed Image
                </a>
            </div>

            @include('layouts.partials.ad', ['position' => 'image-compressor-mid'])

            <x-seo-content title="About the Image Compressor">
                <x-slot:howToUse>
                    <ol class="list-decimal space-y-1.5 pl-5">
                        <li>Drag and drop a JPG, PNG or WebP image, or tap to choose one from your device.</li>
                        <li>Adjust the compression quality slider if needed.</li>
                        <li>Tap Compress Image and review the new file size and percentage saved.</li>
                        <li>Download the compressed image.</li>
                    </ol>
                </x-slot:howToUse>

                <x-slot:explanation>
                    <p>
                        Compressing an image reduces its file size, which makes web pages load faster and uploads quicker, without needing
                        specialist photo editing software. Your image is processed and compressed entirely in memory and is never saved on
                        our servers — once you leave this page, nothing of your image remains.
                    </p>
                </x-slot:explanation>
            </x-seo-content>

            <x-faq :items="[
                ['question' => 'Is my image uploaded and stored anywhere?', 'answer' => 'Your image is sent securely for compression and the result is returned to your browser immediately. It is processed in memory only and is not saved to disk or kept after the response is sent.'],
                ['question' => 'Will compressing reduce image quality?', 'answer' => 'JPG and WebP compression is lossy, so very low quality settings can introduce visible artifacts. PNG compression is lossless, so quality is preserved, though file size savings are typically smaller.'],
                ['question' => 'What is the maximum file size I can upload?', 'answer' => 'Images up to 10MB are supported.'],
            ]" />
        </div>

        <aside class="space-y-6">
            @include('layouts.partials.ad', ['position' => 'image-compressor-sidebar'])
            <x-related-tools :slugs="['image-resizer', 'qr-generator']" />
        </aside>
    </div>
</div>
@endsection

@push('scripts')
    @vite('resources/js/tools/image-compressor.js')
@endpush
