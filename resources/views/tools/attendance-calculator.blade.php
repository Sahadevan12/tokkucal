@extends('layouts.app')

@section('content')
<div class="container-page py-8 sm:py-10">
    <x-breadcrumbs :items="$breadcrumbs" />

    <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Attendance Calculator</h1>
    <p class="mt-3 max-w-2xl text-slate-600">{{ $tool->description }}</p>

    <div class="mt-8 grid gap-8 lg:grid-cols-3 lg:items-start">
        <div class="space-y-6 lg:col-span-2 min-w-0">
            <form id="attendance-form" data-action="{{ route('attendance-calculator.calculate') }}" class="card p-6 sm:p-8" novalidate>
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                    <x-calculator-input name="total_classes" label="Total Classes Held" type="number" min="1" step="1" placeholder="e.g. 90" required />
                    <x-calculator-input name="classes_attended" label="Classes Attended" type="number" min="0" step="1" placeholder="e.g. 70" required />
                    <x-calculator-input name="target_percent" label="Target Attendance %" suffix="%" min="1" max="100" value="75" required />
                </div>

                <button type="submit" class="btn-primary mt-6 w-full sm:w-auto">Calculate</button>
            </form>

            <div id="attendance-result" class="card hidden p-6 sm:p-8" aria-live="polite">
                <h2 class="text-lg font-bold text-slate-900">Result</h2>

                <div class="mt-4 rounded-xl p-5 text-center" id="attendance-headline-card">
                    <p class="text-xs font-medium uppercase tracking-wide" id="attendance-headline-label">Current Attendance</p>
                    <p class="mt-1 text-3xl font-extrabold" id="attendance-current-percent">—</p>
                </div>

                <div class="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-3">
                    <div class="rounded-xl bg-slate-50 p-4 text-center">
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Attended</p>
                        <p class="mt-1 text-lg font-bold text-slate-900" id="attendance-attended">—</p>
                    </div>
                    <div class="rounded-xl bg-slate-50 p-4 text-center">
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Missed</p>
                        <p class="mt-1 text-lg font-bold text-slate-900" id="attendance-missed">—</p>
                    </div>
                    <div class="col-span-2 rounded-xl bg-slate-50 p-4 text-center sm:col-span-1" id="attendance-advice-card">
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500" id="attendance-advice-label">Classes You Can Miss</p>
                        <p class="mt-1 text-lg font-bold text-slate-900" id="attendance-advice-value">—</p>
                    </div>
                </div>
            </div>

            @include('layouts.partials.ad', ['position' => 'attendance-calculator-mid'])

            <x-seo-content title="About the Attendance Calculator">
                <x-slot:howToUse>
                    <ol class="list-decimal space-y-1.5 pl-5">
                        <li>Enter the total number of classes held so far.</li>
                        <li>Enter how many of those you attended.</li>
                        <li>Enter your target attendance percentage (many colleges require 75%).</li>
                        <li>Press Calculate to see your current percentage, and either how many classes you can still miss, or how many more you must attend to hit your target.</li>
                    </ol>
                </x-slot:howToUse>

                <x-slot:formula>
                    <p class="rounded-lg bg-slate-50 px-4 py-2 font-mono text-xs">
                        Attendance % = Attended ÷ Total × 100<br>
                        Classes you can miss: largest x where Attended ÷ (Total + x) ≥ Target%<br>
                        Classes required: smallest y where (Attended + y) ÷ (Total + y) ≥ Target%
                    </p>
                </x-slot:formula>

                <x-slot:example>
                    <p>If you've attended 70 of 90 classes (77.8%) with a 75% target, you're above target and can still miss a few upcoming classes. If you've attended 60 of 90 (66.7%), you're below target and need to attend a run of future classes without missing any to climb back to 75%.</p>
                </x-slot:example>

                <x-slot:explanation>
                    <p>
                        It's tempting to guess "classes you can miss" by simple subtraction, but every future class held changes both the
                        number attended and the total, so the real answer depends on solving for the target percentage directly rather
                        than estimating. That's why this calculator works out the exact number of classes you can miss — or must attend
                        without fail — instead of a rough approximation.
                    </p>
                </x-slot:explanation>
            </x-seo-content>

            <x-faq :items="[
                ['question' => 'What attendance percentage do most colleges require?', 'answer' => '75% is the most common minimum in Indian colleges and universities, though some courses or institutions set a different threshold — check your own institution\'s rule and enter it as the target.'],
                ['question' => 'What if I am already below my target?', 'answer' => 'The calculator shows the minimum number of additional classes you need to attend, without missing any, to bring your percentage back up to the target.'],
                ['question' => 'What if my target is 100%?', 'answer' => 'Once you have missed even a single class, it is mathematically impossible to reach 100% again — the calculator will indicate this rather than showing a number.'],
            ]" />
        </div>

        <aside class="space-y-6">
            @include('layouts.partials.ad', ['position' => 'attendance-calculator-sidebar'])
            <x-related-tools :slugs="['percentage-calculator', 'age-calculator', 'gst-calculator']" />
        </aside>
    </div>
</div>
@endsection

@push('scripts')
    @vite('resources/js/tools/attendance-calculator.js')
@endpush
