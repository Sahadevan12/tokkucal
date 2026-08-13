@extends('layouts.app')

@section('content')
<div class="container-page py-8 sm:py-10">
    <x-breadcrumbs :items="$breadcrumbs" />

    <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">GST Calculator</h1>
    <p class="mt-3 max-w-2xl text-slate-600">{{ $tool->description }}</p>

    <div class="mt-8 grid gap-8 lg:grid-cols-3 lg:items-start">
        <div class="space-y-6 lg:col-span-2 min-w-0">
            <form id="gst-form" data-action="{{ route('gst-calculator.calculate') }}" class="card p-6 sm:p-8" novalidate>
                <div class="flex rounded-xl bg-slate-100 p-1" role="tablist" aria-label="GST calculation mode">
                    <button type="button" data-gst-mode="exclusive" class="gst-mode-btn flex-1 rounded-lg px-4 py-2.5 text-sm font-semibold transition" aria-pressed="true">
                        Add GST (Exclusive)
                    </button>
                    <button type="button" data-gst-mode="inclusive" class="gst-mode-btn flex-1 rounded-lg px-4 py-2.5 text-sm font-semibold transition" aria-pressed="false">
                        Remove GST (Inclusive)
                    </button>
                </div>
                <input type="hidden" name="mode" id="gst-mode-input" value="exclusive">

                <div class="mt-6 space-y-5">
                    <x-calculator-input
                        name="amount"
                        label="Amount"
                        prefix="₹"
                        min="0"
                        placeholder="e.g. 1000"
                        required
                    />

                    <div>
                        <span class="field-label">GST Rate</span>
                        <div class="flex flex-wrap gap-2" role="group" aria-label="Common GST rates">
                            @foreach ([0, 5, 12, 18, 28] as $rate)
                                <button
                                    type="button"
                                    data-gst-rate="{{ $rate }}"
                                    class="gst-rate-chip min-h-11 rounded-lg border border-slate-300 px-4 text-sm font-medium text-slate-700 transition hover:border-indigo-400 {{ $rate === 18 ? 'active' : '' }}"
                                >{{ $rate }}%</button>
                            @endforeach
                        </div>
                        <div class="mt-3">
                            <x-calculator-input
                                name="gst_percent"
                                label="Custom GST %"
                                suffix="%"
                                min="0"
                                value="18"
                                required
                            />
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-primary mt-6 w-full sm:w-auto">Calculate</button>
            </form>

            <div id="gst-result" class="card hidden p-6 sm:p-8" aria-live="polite">
                <h2 class="text-lg font-bold text-slate-900">Result</h2>
                <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div class="rounded-xl bg-slate-50 p-4">
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Base Amount</p>
                        <p class="mt-1 text-2xl font-bold text-slate-900" id="gst-base-amount">—</p>
                    </div>
                    <div class="rounded-xl bg-slate-50 p-4">
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">GST Amount</p>
                        <p class="mt-1 text-2xl font-bold text-slate-900" id="gst-gst-amount">—</p>
                    </div>
                    <div class="rounded-xl bg-indigo-50 p-4">
                        <p class="text-xs font-medium uppercase tracking-wide text-indigo-600">Total Amount</p>
                        <p class="mt-1 text-2xl font-bold text-indigo-700" id="gst-total-amount">—</p>
                    </div>
                </div>
            </div>

            @include('layouts.partials.ad', ['position' => 'gst-calculator-mid'])

            <x-seo-content title="About the GST Calculator">
                <x-slot:howToUse>
                    <ol class="list-decimal space-y-1.5 pl-5">
                        <li>Choose <strong>Add GST</strong> if you have an amount before tax, or <strong>Remove GST</strong> if you have a final price that already includes GST.</li>
                        <li>Enter the amount.</li>
                        <li>Pick a common GST rate (0%, 5%, 12%, 18%, 28%) or type a custom percentage.</li>
                        <li>Press Calculate to see the base amount, GST amount and total.</li>
                    </ol>
                </x-slot:howToUse>

                <x-slot:formula>
                    <p><strong>GST Exclusive</strong> (adding GST to a base amount):</p>
                    <p class="rounded-lg bg-slate-50 px-4 py-2 font-mono text-xs">GST = Amount × GST% ÷ 100<br>Total = Amount + GST</p>
                    <p><strong>GST Inclusive</strong> (extracting GST from a total):</p>
                    <p class="rounded-lg bg-slate-50 px-4 py-2 font-mono text-xs">Base Amount = Total × 100 ÷ (100 + GST%)<br>GST = Total − Base Amount</p>
                </x-slot:formula>

                <x-slot:example>
                    <p>An item costs ₹1,000 before tax, with 18% GST applied:</p>
                    <p class="rounded-lg bg-slate-50 px-4 py-2 font-mono text-xs">GST = 1000 × 18 ÷ 100 = ₹180<br>Total = 1000 + 180 = ₹1,180</p>
                </x-slot:example>

                <x-slot:explanation>
                    <p>
                        Goods and Services Tax (GST) is applied at different rates depending on the category of goods or services in India,
                        with 0%, 5%, 12%, 18% and 28% being the most common slabs. Businesses issuing invoices typically add GST to a base
                        price (exclusive calculation), while a shopper looking at a price tag that already includes tax often needs the
                        reverse (inclusive calculation) to see the pre-tax price.
                    </p>
                </x-slot:explanation>
            </x-seo-content>

            <x-faq :items="[
                ['question' => 'What is the difference between GST exclusive and GST inclusive?', 'answer' => 'GST exclusive means the amount you enter does not yet include GST, and the calculator adds it. GST inclusive means your amount already includes GST, and the calculator extracts the base price and GST portion from it.'],
                ['question' => 'What GST rate should I use?', 'answer' => 'The applicable GST rate depends on the goods or service category, most commonly 5%, 12%, 18% or 28% in India. Check your invoice or the official GST rate schedule if you are unsure.'],
                ['question' => 'Can I use this for a custom GST percentage?', 'answer' => 'Yes. Enter any percentage in the GST rate field — the common rate buttons are just a shortcut for the most frequently used slabs.'],
            ]" />
        </div>

        <aside class="space-y-6">
            @include('layouts.partials.ad', ['position' => 'gst-calculator-sidebar'])
            <x-related-tools :slugs="['discount-calculator', 'salary-calculator', 'emi-calculator']" />
        </aside>
    </div>
</div>
@endsection

@push('scripts')
    @vite('resources/js/tools/gst-calculator.js')
@endpush
