@extends('layouts.app')

@section('content')
<div class="container-page py-8 sm:py-10">
    <x-breadcrumbs :items="$breadcrumbs" />

    <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">EMI Calculator</h1>
    <p class="mt-3 max-w-2xl text-slate-600">{{ $tool->description }}</p>

    <div class="mt-8 grid gap-8 lg:grid-cols-3 lg:items-start">
        <div class="space-y-6 lg:col-span-2">
            <form id="emi-form" data-action="{{ route('emi-calculator.calculate') }}" class="card p-6 sm:p-8" novalidate>
                <div class="space-y-5">
                    <x-calculator-input name="loan_amount" label="Loan Amount" prefix="₹" min="1" placeholder="e.g. 500000" required />
                    <x-calculator-input name="annual_rate" label="Annual Interest Rate" suffix="%" min="0" step="0.01" placeholder="e.g. 8.5" required />

                    <div>
                        <span class="field-label">Loan Tenure</span>
                        <div class="flex gap-3">
                            <input type="number" id="tenure_value" name="tenure_value" min="1" value="5" required class="field-input" aria-label="Tenure value">
                            <select id="tenure_unit" name="tenure_unit" class="field-input max-w-40" aria-label="Tenure unit">
                                <option value="years" selected>Years</option>
                                <option value="months">Months</option>
                            </select>
                        </div>
                        <p id="tenure_value-error" class="field-error hidden" role="alert"></p>
                    </div>
                </div>

                <button type="submit" class="btn-primary mt-6 w-full sm:w-auto">Calculate</button>
            </form>

            <div id="emi-result" class="card hidden p-6 sm:p-8" aria-live="polite">
                <h2 class="text-lg font-bold text-slate-900">Result</h2>
                <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div class="rounded-xl bg-indigo-50 p-4">
                        <p class="text-xs font-medium uppercase tracking-wide text-indigo-600">Monthly EMI</p>
                        <p class="mt-1 text-2xl font-bold text-indigo-700" id="emi-monthly">—</p>
                    </div>
                    <div class="rounded-xl bg-slate-50 p-4">
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Total Interest</p>
                        <p class="mt-1 text-2xl font-bold text-slate-900" id="emi-interest">—</p>
                    </div>
                    <div class="rounded-xl bg-slate-50 p-4">
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Total Payment</p>
                        <p class="mt-1 text-2xl font-bold text-slate-900" id="emi-total">—</p>
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="text-sm font-semibold text-slate-900">Yearly Amortization Summary</h3>
                    <div class="mt-3 overflow-x-auto">
                        <table class="w-full min-w-max text-left text-sm">
                            <thead>
                                <tr class="border-b border-slate-200 text-xs uppercase tracking-wide text-slate-500">
                                    <th class="py-2 pr-4">Year</th>
                                    <th class="py-2 pr-4">Principal Paid</th>
                                    <th class="py-2 pr-4">Interest Paid</th>
                                    <th class="py-2">Balance</th>
                                </tr>
                            </thead>
                            <tbody id="emi-breakdown" class="divide-y divide-slate-100"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            @include('layouts.partials.ad', ['position' => 'emi-calculator-mid'])

            <x-seo-content title="About the EMI Calculator">
                <x-slot:howToUse>
                    <ol class="list-decimal space-y-1.5 pl-5">
                        <li>Enter the loan amount you plan to borrow.</li>
                        <li>Enter the annual interest rate offered by your lender.</li>
                        <li>Enter the loan tenure in years or months.</li>
                        <li>Press Calculate to see your monthly EMI, total interest and a yearly repayment summary.</li>
                    </ol>
                </x-slot:howToUse>

                <x-slot:formula>
                    <p class="rounded-lg bg-slate-50 px-4 py-2 font-mono text-xs">
                        r = Annual Rate ÷ 12 ÷ 100<br>
                        EMI = P × r × (1+r)^N ÷ [(1+r)^N − 1]
                    </p>
                    <p>Where P is the loan amount, r is the monthly interest rate, and N is the number of monthly instalments.</p>
                </x-slot:formula>

                <x-slot:example>
                    <p>A loan of ₹5,00,000 at 8.5% annual interest for 5 years (60 months) works out to an EMI of about ₹10,258, with total interest of roughly ₹1,15,480 over the loan term.</p>
                </x-slot:example>

                <x-slot:explanation>
                    <p>
                        EMI (Equated Monthly Instalment) is the fixed amount you repay every month, made up of a principal portion and an
                        interest portion. Early in the loan, more of each EMI goes towards interest; later, more goes towards principal —
                        which is why the yearly summary above shows interest paid gradually decreasing over time.
                    </p>
                </x-slot:explanation>
            </x-seo-content>

            <x-faq :items="[
                ['question' => 'Does the EMI change during the loan tenure?', 'answer' => 'For a standard fixed-rate loan, the EMI amount stays the same every month. What changes each month is the split between principal and interest within that fixed EMI.'],
                ['question' => 'What if my lender charges a 0% processing fee or 0% interest offer?', 'answer' => 'At 0% interest, the EMI is simply the loan amount divided by the number of months, with no interest component.'],
                ['question' => 'Is this EMI figure exact?', 'answer' => 'This uses the standard reducing-balance EMI formula used by most Indian banks and NBFCs. Your actual EMI may vary slightly due to processing fees, insurance, or rounding conventions used by your specific lender.'],
            ]" />
        </div>

        <aside class="space-y-6">
            @include('layouts.partials.ad', ['position' => 'emi-calculator-sidebar'])
            <x-related-tools :slugs="['gst-calculator', 'salary-calculator', 'discount-calculator']" />
        </aside>
    </div>
</div>
@endsection

@push('scripts')
    @vite('resources/js/tools/emi-calculator.js')
@endpush
