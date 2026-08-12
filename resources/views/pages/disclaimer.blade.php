@extends('layouts.app')

@section('content')
<div class="container-page max-w-3xl py-10 sm:py-14">
    <x-breadcrumbs :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Disclaimer', 'url' => null]]" />

    <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Disclaimer</h1>
    <p class="mt-2 text-sm text-slate-500">Last updated: {{ now()->format('d F Y') }}</p>

    <div class="prose-tool mt-6 space-y-6 text-slate-600">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Informational purposes only</h2>
            <p class="mt-2">
                Every calculator on Tokkucal is provided for general informational purposes only. While we aim for each
                tool to use accurate, standard formulas, results are estimates and should not be treated as professional
                financial, tax, legal or medical advice.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-slate-900">Salary and financial calculators</h2>
            <p class="mt-2">
                The Salary Calculator, EMI Calculator, GST Calculator and similar tools give estimated results based on
                the figures you enter and standard formulas. Actual take-home salary, loan terms, or applicable tax
                depend on your employer's policies, your lender's terms, and current tax rules, which can change and vary
                by individual circumstance. Always verify important financial decisions with your employer, bank, a
                qualified chartered accountant or financial advisor.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-slate-900">Image and QR tools</h2>
            <p class="mt-2">
                The Image Compressor, Image Resizer and QR Code Generator are provided as-is. You are responsible for
                ensuring you have the right to upload, compress, resize or encode any content you use with these tools,
                and for verifying that a generated QR code works correctly before printing or distributing it.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-slate-900">No professional relationship</h2>
            <p class="mt-2">
                Using Tokkucal does not create any advisory, professional or fiduciary relationship between you and
                Tokkucal. For decisions involving significant money, legal standing or health, please consult an
                appropriately qualified professional.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-slate-900">Limitation of accuracy</h2>
            <p class="mt-2">
                We work to keep formulas correct and up to date, but we do not guarantee that every result is free of
                error, or that every tool reflects the very latest rules (for example, tax slabs or GST rates, which can
                change). If you notice something incorrect, please <a href="{{ route('contact') }}">let us know</a>.
            </p>
        </div>
    </div>
</div>
@endsection
