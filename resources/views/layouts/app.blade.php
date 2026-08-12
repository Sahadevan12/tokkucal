<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('tokkucal.site_name').' – '.config('tokkucal.tagline') }}</title>
    <meta name="description" content="{{ $description ?? config('tokkucal.description') }}">
    <link rel="canonical" href="{{ $canonical ?? url()->current() }}">

    @if (config('services.search_console.verification'))
        <meta name="google-site-verification" content="{{ config('services.search_console.verification') }}">
    @endif

    {{-- Open Graph --}}
    <meta property="og:site_name" content="{{ config('tokkucal.site_name') }}">
    <meta property="og:type" content="{{ $ogType ?? 'website' }}">
    <meta property="og:title" content="{{ $title ?? config('tokkucal.site_name') }}">
    <meta property="og:description" content="{{ $description ?? config('tokkucal.description') }}">
    <meta property="og:url" content="{{ $canonical ?? url()->current() }}">
    <meta property="og:image" content="{{ $ogImage ?? asset(config('tokkucal.default_og_image')) }}">

    {{-- Twitter / X --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title ?? config('tokkucal.site_name') }}">
    <meta name="twitter:description" content="{{ $description ?? config('tokkucal.description') }}">
    <meta name="twitter:image" content="{{ $ogImage ?? asset(config('tokkucal.default_og_image')) }}">

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

    @isset($jsonLd)
        <script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    @endisset
    @stack('schema')

    @if (config('services.adsense.enabled') && config('services.adsense.client_id'))
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ config('services.adsense.client_id') }}" crossorigin="anonymous"></script>
    @endif

    @include('layouts.partials.analytics')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="flex min-h-screen flex-col bg-slate-50 text-slate-800">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded-lg focus:bg-indigo-600 focus:px-4 focus:py-2 focus:text-white">
        Skip to content
    </a>

    @include('layouts.partials.header')

    <main id="main-content" class="flex-1">
        @yield('content')
    </main>

    @include('layouts.partials.footer')

    @stack('scripts')
</body>
</html>
