@extends('layouts.app')

@section('content')
<div class="container-page max-w-3xl py-10 sm:py-14">
    <x-breadcrumbs :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'About', 'url' => null]]" />

    <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">About Tokkucal</h1>

    <div class="prose-tool mt-6 space-y-6 text-slate-600">
        <p>
            Tokkucal is a free collection of calculators and utility tools built for everyday tasks — working out GST on an
            invoice, checking a loan EMI, compressing a photo before uploading it, or generating a QR code for a Wi-Fi
            network. Every tool is designed to load fast, work well on a phone, and give you an answer in seconds without
            asking you to sign up or hand over personal information.
        </p>

        <div>
            <h2 class="text-xl font-bold text-slate-900">Why Tokkucal exists</h2>
            <p class="mt-2">
                Most calculator sites are cluttered with pop-ups, forced sign-ups, or slow, ad-heavy pages that get in the
                way of a simple task. Tokkucal was built to do one thing well: give you a clean, fast tool for a specific
                everyday calculation, with clear explanations if you want to understand how the numbers work.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-slate-900">How Tokkucal is funded</h2>
            <p class="mt-2">
                Tokkucal is free to use and supported by advertising. We do not sell user data, and none of the tools
                require an account or store your personal calculations.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-slate-900">What's next</h2>
            <p class="mt-2">
                New tools are added regularly based on what people actually search for and ask about. If there's a
                calculator or utility you'd like to see on Tokkucal, <a href="{{ route('contact') }}">get in touch</a> —
                we read every message.
            </p>
        </div>
    </div>
</div>
@endsection
