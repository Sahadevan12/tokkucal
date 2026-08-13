@extends('layouts.app')

@section('content')
<div class="container-page py-8 sm:py-10">
    <x-breadcrumbs :items="$breadcrumbs" />

    <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Salary Calculator</h1>
    <p class="mt-3 max-w-2xl text-slate-600">{{ $tool->description }}</p>

    <div class="mt-4 max-w-2xl rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
        Estimated calculation only. Actual take-home salary depends on your employer's salary structure, applicable deductions and current tax rules.
    </div>

    <div class="mt-8 grid gap-8 lg:grid-cols-3 lg:items-start">
        <div class="space-y-6 lg:col-span-2 min-w-0">
            <form id="salary-form" data-action="{{ route('salary-calculator.calculate') }}" class="card p-6 sm:p-8" novalidate>
                <p class="text-sm font-semibold text-slate-900">Enter annual amounts (₹ per year)</p>
                <div class="mt-4 grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <x-calculator-input name="annual_ctc" label="Annual CTC" prefix="₹" min="0" required />
                    <x-calculator-input name="basic" label="Basic Salary" prefix="₹" min="0" required />
                    <x-calculator-input name="hra" label="HRA" prefix="₹" min="0" required />
                    <x-calculator-input name="allowances" label="Other Allowances" prefix="₹" min="0" required />
                    <x-calculator-input name="bonus" label="Bonus" prefix="₹" min="0" required />
                    <x-calculator-input name="pf" label="Provident Fund (PF)" prefix="₹" min="0" required />
                    <x-calculator-input name="professional_tax" label="Professional Tax" prefix="₹" min="0" required />
                    <x-calculator-input name="other_deductions" label="Other Deductions" prefix="₹" min="0" required />
                </div>

                <button type="submit" class="btn-primary mt-6 w-full sm:w-auto">Calculate</button>
            </form>

            <div id="salary-result" class="card hidden p-6 sm:p-8" aria-live="polite">
                <h2 class="text-lg font-bold text-slate-900">Result</h2>

                <div class="mt-4 rounded-xl bg-indigo-50 p-5 text-center">
                    <p class="text-xs font-medium uppercase tracking-wide text-indigo-600">Estimated Monthly Take-Home</p>
                    <p class="mt-1 text-2xl font-extrabold text-indigo-700" id="salary-monthly-take-home">—</p>
                    <p class="mt-1 text-sm text-indigo-600" id="salary-annual-take-home">—</p>
                </div>

                <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="rounded-xl bg-slate-50 p-4">
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Annual CTC</p>
                        <p class="mt-1 text-lg font-bold text-slate-900" id="salary-annual-ctc">—</p>
                        <p class="text-xs text-slate-500" id="salary-monthly-ctc">—</p>
                    </div>
                    <div class="rounded-xl bg-slate-50 p-4">
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Gross Salary</p>
                        <p class="mt-1 text-lg font-bold text-slate-900" id="salary-gross">—</p>
                        <p class="text-xs text-slate-500" id="salary-monthly-gross">—</p>
                    </div>
                    <div class="rounded-xl bg-slate-50 p-4 sm:col-span-2">
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Estimated Deductions (PF + Professional Tax + Other)</p>
                        <p class="mt-1 text-lg font-bold text-slate-900" id="salary-deductions">—</p>
                    </div>
                </div>
            </div>

            @include('layouts.partials.ad', ['position' => 'salary-calculator-mid'])

            <x-seo-content title="About the Salary Calculator">
                <x-slot:howToUse>
                    <ol class="list-decimal space-y-1.5 pl-5">
                        <li>Enter your annual CTC as mentioned in your offer letter or payslip.</li>
                        <li>Enter the annual Basic, HRA, Allowances and Bonus components.</li>
                        <li>Enter your annual PF contribution, professional tax and any other deductions.</li>
                        <li>Press Calculate to see your estimated gross salary and take-home pay.</li>
                    </ol>
                </x-slot:howToUse>

                <x-slot:formula>
                    <p class="rounded-lg bg-slate-50 px-4 py-2 font-mono text-xs">
                        Gross Salary = Basic + HRA + Allowances + Bonus<br>
                        Estimated Deductions = PF + Professional Tax + Other Deductions<br>
                        Take-Home = Gross Salary − Estimated Deductions
                    </p>
                </x-slot:formula>

                <x-slot:explanation>
                    <p>
                        This calculator gives a simplified estimate based on the salary components you enter. It does not calculate income
                        tax (TDS), since that depends on your tax regime, exemptions and deductions under the Income Tax Act, which vary
                        from person to person. For an exact take-home figure, check your payslip or consult your employer's payroll team.
                    </p>
                </x-slot:explanation>
            </x-seo-content>

            <x-faq :items="[
                ['question' => 'Does this calculator include income tax?', 'answer' => 'No. Income tax depends on your tax regime, exemptions and deductions, which vary by individual. This tool only nets off PF, professional tax and other deductions you enter.'],
                ['question' => 'Why is my actual take-home different from this estimate?', 'answer' => 'Actual take-home pay also depends on income tax deducted at source (TDS), employer-specific policies, and how your CTC is structured, which this simplified calculator does not model.'],
                ['question' => 'What counts as \'Other Deductions\'?', 'answer' => 'Anything else deducted from your salary that is not PF or professional tax, such as loan repayments, insurance premiums or voluntary deductions.'],
            ]" />
        </div>

        <aside class="space-y-6">
            @include('layouts.partials.ad', ['position' => 'salary-calculator-sidebar'])
            <x-related-tools :slugs="['emi-calculator', 'gst-calculator', 'discount-calculator']" />
        </aside>
    </div>
</div>
@endsection

@push('scripts')
    @vite('resources/js/tools/salary-calculator.js')
@endpush
