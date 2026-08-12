@props(['slugs', 'heading' => 'Related Tools'])

@php
    $relatedTools = \App\Models\Tool::active()->whereIn('slug', $slugs)->ordered()->get();
@endphp

@if ($relatedTools->isNotEmpty())
    <section aria-labelledby="related-tools-heading">
        <h2 id="related-tools-heading" class="text-xl font-bold text-slate-900">{{ $heading }}</h2>
        <div class="mt-4 grid grid-cols-1 gap-4">
            @foreach ($relatedTools as $tool)
                <x-tool-card :tool="$tool" />
            @endforeach
        </div>
    </section>
@endif
