@extends('layouts.app')

@section('content')
<div class="container-page py-8 sm:py-10">
    <x-breadcrumbs :items="$breadcrumbs" />

    <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Percentage Calculator</h1>
    <p class="mt-3 max-w-2xl text-slate-600">{{ $tool->description }}</p>

    <div class="mt-8 grid gap-8 lg:grid-cols-3 lg:items-start">
        <div class="space-y-6 lg:col-span-2">
            <form id="percentage-form" data-action="{{ route('percentage-calculator.calculate') }}" class="card p-6 sm:p-8" novalidate>
                <div class="grid grid-cols-1 gap-1 rounded-xl bg-slate-100 p-1 sm:grid-cols-3" role="tablist" aria-label="Percentage calculation mode">
                    <button type="button" data-percentage-mode="of" class="percentage-mode-btn rounded-lg px-3 py-2.5 text-sm font-semibold transition" aria-pressed="true">X% of Y</button>
                    <button type="button" data-percentage-mode="is-percent" class="percentage-mode-btn rounded-lg px-3 py-2.5 text-sm font-semibold transition" aria-pressed="false">X is what % of Y</button>
                    <button type="button" data-percentage-mode="change" class="percentage-mode-btn rounded-lg px-3 py-2.5 text-sm font-semibold transition" aria-pressed="false">% Increase / Decrease</button>
                </div>
                <input type="hidden" name="mode" id="percentage-mode-input" value="of">

                <div class="mt-6 space-y-5" data-percentage-panel="of">
                    <x-calculator-input name="of_percent" label="Percentage (X)" suffix="%" placeholder="e.g. 20" required />
                    <x-calculator-input name="of_of_value" label="Of Value (Y)" placeholder="e.g. 250" required />
                </div>

                <div class="mt-6 hidden space-y-5" data-percentage-panel="is-percent">
                    <x-calculator-input name="isp_value" label="Value (X)" placeholder="e.g. 50" />
                    <x-calculator-input name="isp_of_value" label="Of Value (Y)" placeholder="e.g. 250" />
                </div>

                <div class="mt-6 hidden space-y-5" data-percentage-panel="change">
                    <x-calculator-input name="chg_old_value" label="Old Value" placeholder="e.g. 200" />
                    <x-calculator-input name="chg_new_value" label="New Value" placeholder="e.g. 250" />
                </div>

                <button type="submit" class="btn-primary mt-6 w-full sm:w-auto">Calculate</button>
            </form>

            <div id="percentage-result" class="card hidden p-6 sm:p-8 text-center" aria-live="polite">
                <p class="text-xs font-medium uppercase tracking-wide text-slate-500" id="percentage-result-label">Result</p>
                <p class="mt-2 text-4xl font-extrabold text-indigo-700" id="percentage-result-value">—</p>
            </div>

            @include('layouts.partials.ad', ['position' => 'percentage-calculator-mid'])

            <x-seo-content title="About the Percentage Calculator">
                <x-slot:howToUse>
                    <ol class="list-decimal space-y-1.5 pl-5">
                        <li>Pick the calculation you need: a percentage of a number, what percentage one value is of another, or a percentage increase/decrease.</li>
                        <li>Fill in the two values for that mode.</li>
                        <li>Press Calculate to see the result instantly.</li>
                    </ol>
                </x-slot:howToUse>

                <x-slot:formula>
                    <p class="rounded-lg bg-slate-50 px-4 py-2 font-mono text-xs">
                        X% of Y = X × Y ÷ 100<br>
                        X is what % of Y = X ÷ Y × 100<br>
                        % change = (New − Old) ÷ Old × 100
                    </p>
                </x-slot:formula>

                <x-slot:example>
                    <p>20% of 250 = 50. And 50 is 20% of 250. If a value rises from 200 to 250, that is a 25% increase.</p>
                </x-slot:example>

                <x-slot:explanation>
                    <p>
                        Percentages express a number as a fraction of 100, which makes it easy to compare quantities of different sizes.
                        Percentage increase and decrease use the same underlying formula — the sign of the result tells you the direction —
                        so this calculator combines both into a single "change" mode.
                    </p>
                </x-slot:explanation>
            </x-seo-content>

            <x-faq :items="[
                ['question' => 'How do I calculate a percentage increase?', 'answer' => 'Use the % Increase / Decrease tab, enter the old and new values, and the calculator will show the percentage change along with whether it is an increase or decrease.'],
                ['question' => 'Can I calculate what percentage one number is of another?', 'answer' => 'Yes, use the \'X is what % of Y\' tab. For example, entering 50 and 250 tells you that 50 is 20% of 250.'],
                ['question' => 'Can the of-value be zero?', 'answer' => 'The of-value can be zero for the \'X% of Y\' mode, but it cannot be zero when it is used as a divisor, such as in the \'is what percent\' and \'% change\' modes.'],
            ]" />
        </div>

        <aside class="space-y-6">
            @include('layouts.partials.ad', ['position' => 'percentage-calculator-sidebar'])
            <x-related-tools :slugs="['attendance-calculator', 'age-calculator', 'discount-calculator']" />
        </aside>
    </div>
</div>
@endsection

@push('scripts')
    @vite('resources/js/tools/percentage-calculator.js')
@endpush
