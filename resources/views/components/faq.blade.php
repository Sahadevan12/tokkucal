@props(['items', 'heading' => 'Frequently Asked Questions'])

@if (!empty($items))
    <section aria-labelledby="faq-heading">
        <h2 id="faq-heading" class="text-xl font-bold text-slate-900">{{ $heading }}</h2>

        <div class="mt-4 divide-y divide-slate-200 card px-5">
            @foreach ($items as $item)
                <details class="group py-4">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-medium text-slate-900 marker:content-none">
                        <span>{{ $item['question'] }}</span>
                        <x-icon name="chevron-down" class="w-5 h-5 shrink-0 text-slate-400 transition group-open:rotate-180" />
                    </summary>
                    <p class="mt-3 text-sm leading-relaxed text-slate-600">{{ $item['answer'] }}</p>
                </details>
            @endforeach
        </div>
    </section>

    @push('schema')
        <script type="application/ld+json">
            {!! json_encode([
                '@@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => collect($items)->map(fn ($item) => [
                    '@type' => 'Question',
                    'name' => $item['question'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $item['answer'],
                    ],
                ])->all(),
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
    @endpush
@endif
