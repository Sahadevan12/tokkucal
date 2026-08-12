@props(['title' => null])

<section class="card p-6 sm:p-8">
    @if ($title)
        <h2 class="text-xl font-bold text-slate-900">{{ $title }}</h2>
    @endif

    <div class="prose-tool mt-4 max-w-none space-y-8 text-slate-600">
        @isset($howToUse)
            <div>
                <h3 class="text-base font-semibold text-slate-900">How to Use</h3>
                <div class="mt-2 space-y-2 text-sm leading-relaxed">{{ $howToUse }}</div>
            </div>
        @endisset

        @isset($formula)
            <div>
                <h3 class="text-base font-semibold text-slate-900">Formula</h3>
                <div class="mt-2 space-y-2 text-sm leading-relaxed">{{ $formula }}</div>
            </div>
        @endisset

        @isset($example)
            <div>
                <h3 class="text-base font-semibold text-slate-900">Example</h3>
                <div class="mt-2 space-y-2 text-sm leading-relaxed">{{ $example }}</div>
            </div>
        @endisset

        @isset($explanation)
            <div>
                <h3 class="text-base font-semibold text-slate-900">{{ $explanationTitle ?? 'Detailed Explanation' }}</h3>
                <div class="mt-2 space-y-2 text-sm leading-relaxed">{{ $explanation }}</div>
            </div>
        @endisset

        {{ $slot ?? '' }}
    </div>
</section>
