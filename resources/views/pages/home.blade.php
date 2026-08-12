@extends('layouts.app')

@section('content')
    <section class="border-b border-slate-200 bg-gradient-to-b from-indigo-50 to-slate-50">
        <div class="container-page py-14 text-center sm:py-20">
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-5xl">
                Free Tools for Everyday Life
            </h1>
            <p class="mx-auto mt-4 max-w-xl text-base text-slate-600 sm:text-lg">
                Fast, simple and free online calculators and utility tools.
            </p>

            <div class="mx-auto mt-8 max-w-xl">
                <div class="relative text-left" data-tool-search>
                    <label for="hero-tool-search" class="sr-only">Search tools</label>
                    <x-icon name="search" class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" />
                    <input
                        id="hero-tool-search"
                        data-tool-search-input
                        type="search"
                        placeholder="Search for a tool… e.g. GST, age, image"
                        autocomplete="off"
                        class="field-input min-h-14 rounded-2xl pl-12 text-base shadow-md"
                    >
                    <div data-tool-search-results class="absolute z-50 mt-2 hidden w-full divide-y divide-slate-100 overflow-hidden rounded-2xl border border-slate-200 bg-white text-left shadow-lg"></div>
                </div>
            </div>
        </div>
    </section>

    <section id="popular-tools" class="container-page scroll-mt-20 py-12">
        <h2 class="text-2xl font-bold text-slate-900">Popular Tools</h2>
        <p class="mt-1 text-slate-500">The tools people use most on Tokkucal.</p>
        <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($popularTools as $tool)
                <x-tool-card :tool="$tool" />
            @endforeach
        </div>
    </section>

    <section class="container-page">
        @include('layouts.partials.ad', ['position' => 'home-mid'])
    </section>

    @foreach (config('tokkucal.categories') as $key => $label)
        @continue($toolsByCategory->get($key, collect())->isEmpty())
        <section id="{{ $key }}-tools" class="container-page scroll-mt-20 py-12">
            <h2 class="text-2xl font-bold text-slate-900">{{ $label }}</h2>
            <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($toolsByCategory->get($key) as $tool)
                    <x-tool-card :tool="$tool" />
                @endforeach
            </div>
        </section>
    @endforeach

    <section class="container-page py-12">
        <x-seo-content title="About Tokkucal">
            <x-slot:explanation>
                <p>
                    Tokkucal is a free collection of calculators and utility tools built for everyday use — from working out GST and EMI
                    to compressing an image before you upload it somewhere. Every tool runs instantly in your browser, works well on a
                    phone on a slow connection, and never asks you to sign up.
                </p>
                <p>
                    New tools are added regularly. If there's a calculator you'd like to see, <a href="{{ route('contact') }}">let us know</a>.
                </p>
            </x-slot:explanation>
        </x-seo-content>
    </section>

    <section class="container-page pb-16">
        <x-faq :items="[
            ['question' => 'Is Tokkucal really free to use?', 'answer' => 'Yes. Every calculator and tool on Tokkucal is free to use with no sign-up or account required.'],
            ['question' => 'Do I need to create an account?', 'answer' => 'No. None of Tokkucal\'s tools require login or registration — just open a tool and use it.'],
            ['question' => 'Is my data safe when I use the image or QR tools?', 'answer' => 'Yes. QR codes are generated entirely in your browser and never uploaded anywhere. Images you upload for compressing or resizing are processed temporarily and deleted automatically afterwards.'],
            ['question' => 'Can I use Tokkucal on my mobile phone?', 'answer' => 'Yes, every tool is designed mobile-first and works smoothly on phones, tablets and desktops.'],
            ['question' => 'How accurate are the calculators?', 'answer' => 'Each calculator uses the standard formula for that calculation. Tools like the Salary Calculator give estimates only, since exact results depend on your employer\'s policies and applicable tax rules.'],
        ]" />
    </section>
@endsection
