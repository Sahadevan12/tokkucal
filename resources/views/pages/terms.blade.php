@extends('layouts.app')

@section('content')
<div class="container-page max-w-3xl py-10 sm:py-14">
    <x-breadcrumbs :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Terms', 'url' => null]]" />

    <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Terms of Service</h1>
    <p class="mt-2 text-sm text-slate-500">Last updated: {{ now()->format('d F Y') }}</p>

    <div class="prose-tool mt-6 space-y-6 text-slate-600">
        <p>
            By using Tokkucal ("the Site"), you agree to these terms. If you do not agree, please do not use the Site.
        </p>

        <div>
            <h2 class="text-xl font-bold text-slate-900">Use of the Site</h2>
            <p class="mt-2">
                Tokkucal's tools are provided for personal, informational and non-commercial use unless stated otherwise.
                You agree not to misuse the Site — including attempting to disrupt it, scrape it at scale, upload
                unlawful or harmful content to the image tools, or interfere with other visitors' use of the Site.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-slate-900">No warranty</h2>
            <p class="mt-2">
                The Site and its tools are provided "as is" without warranties of any kind, express or implied. We do not
                guarantee that calculations will be error-free, uninterrupted, or fit for a particular purpose. See our
                <a href="{{ route('disclaimer') }}">Disclaimer</a> for more on calculator accuracy.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-slate-900">Limitation of liability</h2>
            <p class="mt-2">
                To the fullest extent permitted by law, Tokkucal and its operators are not liable for any indirect,
                incidental or consequential loss arising from your use of, or inability to use, the Site or its results.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-slate-900">Intellectual property</h2>
            <p class="mt-2">
                The Site's design, code and content are owned by Tokkucal unless otherwise credited. You may not copy,
                resell or republish substantial parts of the Site without permission.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-slate-900">Third-party links and services</h2>
            <p class="mt-2">
                The Site may link to third-party websites, and may display advertising served by third parties such as
                Google. We are not responsible for the content, accuracy or practices of any third-party site.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-slate-900">Changes to these terms</h2>
            <p class="mt-2">We may update these terms from time to time. Continued use of the Site after changes are posted means you accept the updated terms.</p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-slate-900">Governing law</h2>
            <p class="mt-2">These terms are governed by the laws of India.</p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-slate-900">Contact</h2>
            <p class="mt-2">Questions about these terms can be sent via our <a href="{{ route('contact') }}">Contact page</a>.</p>
        </div>
    </div>
</div>
@endsection
