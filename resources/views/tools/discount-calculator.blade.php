@extends('layouts.app')

@section('content')
<div class="container-page py-8 sm:py-10">
    <x-breadcrumbs :items="$breadcrumbs" />

    <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Discount Calculator</h1>
    <p class="mt-3 max-w-2xl text-slate-600">{{ $tool->description }}</p>

    <div class="mt-8 grid gap-8 lg:grid-cols-3 lg:items-start">
        <div class="space-y-6 lg:col-span-2">
            <form id="discount-form" data-action="{{ route('discount-calculator.calculate') }}" class="card p-6 sm:p-8" novalidate>
                <div class="flex rounded-xl bg-slate-100 p-1" role="tablist" aria-label="Discount calculation mode">
                    <button type="button" data-discount-mode="percent" class="discount-mode-btn flex-1 rounded-lg px-4 py-2.5 text-sm font-semibold transition" aria-pressed="true">
                        I know the discount %
                    </button>
                    <button type="button" data-discount-mode="sale-price" class="discount-mode-btn flex-1 rounded-lg px-4 py-2.5 text-sm font-semibold transition" aria-pressed="false">
                        I know the sale price
                    </button>
                </div>
                <input type="hidden" name="mode" id="discount-mode-input" value="percent">

                <div class="mt-6 space-y-5">
                    <x-calculator-input name="original_price" label="Original Price" prefix="₹" min="0.01" required />

                    <div data-discount-panel="percent">
                        <x-calculator-input name="discount_percent" label="Discount Percentage" suffix="%" min="0" max="100" required />
                    </div>

                    <div data-discount-panel="sale-price" class="hidden">
                        <x-calculator-input name="sale_price" label="Sale Price" prefix="₹" min="0" />
                    </div>
                </div>

                <button type="submit" class="btn-primary mt-6 w-full sm:w-auto">Calculate</button>
            </form>

            <div id="discount-result" class="card hidden p-6 sm:p-8" aria-live="polite">
                <h2 class="text-lg font-bold text-slate-900">Result</h2>
                <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div class="rounded-xl bg-slate-50 p-4">
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Discount Amount</p>
                        <p class="mt-1 text-2xl font-bold text-slate-900" id="discount-amount">—</p>
                    </div>
                    <div class="rounded-xl bg-slate-50 p-4">
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Discount %</p>
                        <p class="mt-1 text-2xl font-bold text-slate-900" id="discount-percent-out">—</p>
                    </div>
                    <div class="rounded-xl bg-indigo-50 p-4">
                        <p class="text-xs font-medium uppercase tracking-wide text-indigo-600">Final Price</p>
                        <p class="mt-1 text-2xl font-bold text-indigo-700" id="discount-final-price">—</p>
                    </div>
                </div>
            </div>

            @include('layouts.partials.ad', ['position' => 'discount-calculator-mid'])

            <x-seo-content title="About the Discount Calculator">
                <x-slot:howToUse>
                    <ol class="list-decimal space-y-1.5 pl-5">
                        <li>Enter the original price of the item.</li>
                        <li>If you know the discount percentage, enter it directly. If you only know the final sale price, switch to that tab instead.</li>
                        <li>Press Calculate to see the discount amount, discount percentage and final price.</li>
                    </ol>
                </x-slot:howToUse>

                <x-slot:formula>
                    <p class="rounded-lg bg-slate-50 px-4 py-2 font-mono text-xs">
                        Discount = Original × Discount% ÷ 100<br>
                        Final Price = Original − Discount
                    </p>
                </x-slot:formula>

                <x-slot:example>
                    <p>A ₹2,000 item with a 25% discount: Discount = 2000 × 25 ÷ 100 = ₹500. Final Price = 2000 − 500 = ₹1,500.</p>
                </x-slot:example>
            </x-seo-content>

            <x-faq :items="[
                ['question' => 'How do I find the discount percentage if I only know the sale price?', 'answer' => 'Switch to the \'I know the sale price\' tab, enter the original and sale price, and the calculator works out the discount amount and percentage for you.'],
                ['question' => 'Can the discount percentage be more than 100%?', 'answer' => 'No — a discount percentage above 100% would mean a negative price, so it is capped at 100%.'],
            ]" />
        </div>

        <aside class="space-y-6">
            @include('layouts.partials.ad', ['position' => 'discount-calculator-sidebar'])
            <x-related-tools :slugs="['gst-calculator', 'percentage-calculator', 'salary-calculator']" />
        </aside>
    </div>
</div>
@endsection

@push('scripts')
    @vite('resources/js/tools/discount-calculator.js')
@endpush
