@extends('layouts.app')

@section('content')
<div class="container-page py-8 sm:py-10">
    <x-breadcrumbs :items="$breadcrumbs" />

    <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Age Calculator</h1>
    <p class="mt-3 max-w-2xl text-slate-600">{{ $tool->description }}</p>

    <div class="mt-8 grid gap-8 lg:grid-cols-3 lg:items-start">
        <div class="space-y-6 lg:col-span-2 min-w-0">
            <form id="age-form" data-action="{{ route('age-calculator.calculate') }}" class="card p-6 sm:p-8" novalidate>
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <x-calculator-input name="date_of_birth" type="date" label="Date of Birth" required />
                    <x-calculator-input name="target_date" type="date" label="Calculate Age On" help="Defaults to today if left blank." />
                </div>

                <button type="submit" class="btn-primary mt-6 w-full sm:w-auto">Calculate</button>
            </form>

            <div id="age-result" class="card hidden p-6 sm:p-8" aria-live="polite">
                <h2 class="text-lg font-bold text-slate-900">Result</h2>

                <div class="mt-4 rounded-xl bg-indigo-50 p-5 text-center">
                    <p class="text-xs font-medium uppercase tracking-wide text-indigo-600">Your Age</p>
                    <p class="mt-1 text-2xl font-extrabold text-indigo-700" id="age-headline">—</p>
                </div>

                <div class="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-4">
                    <div class="rounded-xl bg-slate-50 p-4 text-center">
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Total Days</p>
                        <p class="mt-1 text-lg font-bold text-slate-900" id="age-total-days">—</p>
                    </div>
                    <div class="rounded-xl bg-slate-50 p-4 text-center">
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Total Weeks</p>
                        <p class="mt-1 text-lg font-bold text-slate-900" id="age-total-weeks">—</p>
                    </div>
                    <div class="rounded-xl bg-slate-50 p-4 text-center">
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Total Months</p>
                        <p class="mt-1 text-lg font-bold text-slate-900" id="age-total-months">—</p>
                    </div>
                    <div class="rounded-xl bg-slate-50 p-4 text-center">
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Next Birthday</p>
                        <p class="mt-1 text-lg font-bold text-slate-900" id="age-next-birthday">—</p>
                    </div>
                </div>
            </div>

            @include('layouts.partials.ad', ['position' => 'age-calculator-mid'])

            <x-seo-content title="About the Age Calculator">
                <x-slot:howToUse>
                    <ol class="list-decimal space-y-1.5 pl-5">
                        <li>Enter your date of birth.</li>
                        <li>Optionally change the "Calculate Age On" date — leave it blank to use today.</li>
                        <li>Press Calculate to see your exact age, total days lived and days until your next birthday.</li>
                    </ol>
                </x-slot:howToUse>

                <x-slot:explanation>
                    <p>
                        This calculator works out your exact age using calendar-aware date arithmetic, correctly accounting for leap years
                        and the varying number of days in each month — rather than a rough estimate like dividing total days by 365, which
                        drifts by roughly a day for every four years due to leap years.
                    </p>
                </x-slot:explanation>
            </x-seo-content>

            <x-faq :items="[
                ['question' => 'Does this account for leap years?', 'answer' => 'Yes. The calculation uses proper calendar date arithmetic rather than a fixed 365-day year, so leap years and varying month lengths are handled correctly.'],
                ['question' => 'Can I calculate age as of a future or past date?', 'answer' => 'Yes, change the \'Calculate Age On\' field to any date to see the age as of that date, not just today.'],
                ['question' => 'What if I was born on 29 February?', 'answer' => 'Your age is still calculated exactly. In non-leap years, your next-birthday countdown treats 1 March as the equivalent date.'],
            ]" />
        </div>

        <aside class="space-y-6">
            @include('layouts.partials.ad', ['position' => 'age-calculator-sidebar'])
            <x-related-tools :slugs="['percentage-calculator', 'attendance-calculator', 'salary-calculator']" />
        </aside>
    </div>
</div>
@endsection

@push('scripts')
    @vite('resources/js/tools/age-calculator.js')
@endpush
