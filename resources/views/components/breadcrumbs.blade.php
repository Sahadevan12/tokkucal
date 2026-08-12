@props(['items'])

<nav aria-label="Breadcrumb" class="text-sm">
    <ol class="flex flex-wrap items-center gap-1.5 text-slate-500">
        @foreach ($items as $index => $item)
            <li class="flex items-center gap-1.5">
                @if ($index > 0)
                    <x-icon name="chevron-right" class="w-3.5 h-3.5 text-slate-400" />
                @endif

                @if (!empty($item['url']) && $index < count($items) - 1)
                    <a href="{{ $item['url'] }}" class="hover:text-indigo-600">{{ $item['label'] }}</a>
                @else
                    <span class="font-medium text-slate-700" aria-current="page">{{ $item['label'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>

@push('schema')
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => collect($items)->values()->map(fn ($item, $index) => array_filter([
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $item['label'],
                'item' => $item['url'] ?? null,
            ]))->all(),
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
@endpush
