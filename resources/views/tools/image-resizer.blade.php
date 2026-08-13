@extends('layouts.app')

@section('content')
<div class="container-page py-8 sm:py-10">
    <x-breadcrumbs :items="$breadcrumbs" />

    <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Image Resizer</h1>
    <p class="mt-3 max-w-2xl text-slate-600">{{ $tool->description }}</p>

    <div class="mt-8 grid gap-8 lg:grid-cols-3 lg:items-start">
        <div class="space-y-6 lg:col-span-2 min-w-0">
            <div class="card p-6 sm:p-8">
                <div
                    id="resizer-dropzone"
                    data-action="{{ route('image-resizer.process') }}"
                    class="flex min-h-48 cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-slate-300 bg-slate-50 p-6 text-center transition hover:border-indigo-400"
                    role="button"
                    tabindex="0"
                    aria-label="Choose an image to resize"
                >
                    <x-icon name="upload" class="h-8 w-8 text-slate-400" />
                    <p class="mt-3 text-sm font-medium text-slate-700">Drag and drop an image here, or tap to choose a file</p>
                    <p class="mt-1 text-xs text-slate-500">JPG, PNG or WebP — up to 10MB</p>
                    <input type="file" id="resizer-file-input" accept="image/jpeg,image/png,image/webp" class="sr-only">
                </div>
                <p id="resizer-file-error" class="field-error hidden" role="alert"></p>

                <div id="resizer-controls" class="mt-6 hidden">
                    <div class="flex items-center gap-4">
                        <img id="resizer-preview" src="" alt="Selected image preview" class="h-20 w-20 shrink-0 rounded-xl border border-slate-200 object-cover">
                        <div class="min-w-0">
                            <p id="resizer-filename" class="truncate text-sm font-medium text-slate-900"></p>
                            <p id="resizer-original-dims" class="text-sm text-slate-500"></p>
                        </div>
                    </div>

                    <div class="mt-5">
                        <span class="field-label">Preset</span>
                        <div class="flex flex-wrap gap-2" role="group" aria-label="Resize presets">
                            <button type="button" class="resizer-preset-btn min-h-11 rounded-lg border border-slate-300 px-3 text-sm font-medium text-slate-700 hover:border-indigo-400" data-width="1080" data-height="1080">Instagram (1080×1080)</button>
                            <button type="button" class="resizer-preset-btn min-h-11 rounded-lg border border-slate-300 px-3 text-sm font-medium text-slate-700 hover:border-indigo-400" data-width="500" data-height="500">WhatsApp DP (500×500)</button>
                            <button type="button" class="resizer-preset-btn min-h-11 rounded-lg border border-slate-300 px-3 text-sm font-medium text-slate-700 hover:border-indigo-400" data-width="1280" data-height="720">YouTube Thumbnail (1280×720)</button>
                            <button type="button" class="resizer-preset-btn min-h-11 rounded-lg border border-slate-300 px-3 text-sm font-medium text-slate-700 hover:border-indigo-400" data-width="400" data-height="400">Profile Photo (400×400)</button>
                            <button type="button" class="resizer-preset-btn min-h-11 rounded-lg border border-slate-300 px-3 text-sm font-medium text-slate-700 hover:border-indigo-400" data-width="600" data-height="600">Passport (600×600)</button>
                            <button type="button" id="resizer-preset-custom" class="resizer-preset-btn active min-h-11 rounded-lg border border-slate-300 px-3 text-sm font-medium text-slate-700 hover:border-indigo-400">Custom</button>
                        </div>
                    </div>

                    <div class="mt-5 grid grid-cols-2 gap-4">
                        <x-calculator-input name="width" label="Width (px)" min="1" placeholder="e.g. 800" />
                        <x-calculator-input name="height" label="Height (px)" min="1" placeholder="e.g. 600" />
                    </div>

                    <label class="mt-4 flex min-h-11 items-center gap-2 text-sm text-slate-700">
                        <input type="checkbox" id="resizer-maintain-ratio" checked class="h-5 w-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        Maintain aspect ratio
                    </label>

                    <div class="mt-4">
                        <label for="resizer-output-format" class="field-label">Output Format</label>
                        <select id="resizer-output-format" class="field-input max-w-48">
                            <option value="jpg">JPG</option>
                            <option value="png">PNG</option>
                            <option value="webp">WebP</option>
                        </select>
                    </div>

                    <div class="mt-5 flex flex-wrap gap-3">
                        <button type="button" id="resizer-resize-btn" class="btn-primary">Resize Image</button>
                        <button type="button" id="resizer-reset-btn" class="btn-secondary">
                            <x-icon name="reset" class="h-4 w-4" /> Reset
                        </button>
                    </div>
                </div>
            </div>

            <div id="resizer-result" class="card hidden p-6 sm:p-8" aria-live="polite">
                <h2 class="text-lg font-bold text-slate-900">Result</h2>
                <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="rounded-xl bg-slate-50 p-4">
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">New Dimensions</p>
                        <p class="mt-1 text-lg font-bold text-slate-900" id="resizer-result-dims">—</p>
                    </div>
                    <div class="rounded-xl bg-slate-50 p-4">
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">File Size</p>
                        <p class="mt-1 text-lg font-bold text-slate-900" id="resizer-result-size">—</p>
                    </div>
                </div>
                <a id="resizer-download-btn" href="#" download class="btn-primary mt-5 w-full sm:w-auto">
                    <x-icon name="download" class="h-4 w-4" /> Download Resized Image
                </a>
            </div>

            @include('layouts.partials.ad', ['position' => 'image-resizer-mid'])

            <x-seo-content title="About the Image Resizer">
                <x-slot:howToUse>
                    <ol class="list-decimal space-y-1.5 pl-5">
                        <li>Drag and drop an image, or tap to choose one from your device.</li>
                        <li>Pick a preset size, or enter a custom width and height.</li>
                        <li>Choose whether to keep the original aspect ratio, and an output format.</li>
                        <li>Tap Resize Image and download the result.</li>
                    </ol>
                </x-slot:howToUse>

                <x-slot:explanation>
                    <p>
                        Resizing changes an image's pixel dimensions, which is useful for meeting a platform's upload requirements or
                        reducing file size for faster loading. With "Maintain aspect ratio" on, the image is scaled proportionally to fit
                        within your chosen width and height without stretching or distortion.
                    </p>
                </x-slot:explanation>
            </x-seo-content>

            <x-faq :items="[
                ['question' => 'Will resizing distort my image?', 'answer' => 'Not if \'Maintain aspect ratio\' is checked — the image is scaled proportionally. Unchecking it stretches the image to exactly match the width and height you enter, which can distort it if the ratio does not match the original.'],
                ['question' => 'Are the preset sizes exact requirements?', 'answer' => 'Presets use commonly recommended dimensions for each platform. Always double check the current official requirements for critical use cases like passport photos.'],
            ]" />
        </div>

        <aside class="space-y-6">
            @include('layouts.partials.ad', ['position' => 'image-resizer-sidebar'])
            <x-related-tools :slugs="['image-compressor', 'qr-generator']" />
        </aside>
    </div>
</div>
@endsection

@push('scripts')
    @vite('resources/js/tools/image-resizer.js')
@endpush
