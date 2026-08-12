@extends('layouts.app')

@section('content')
<div class="container-page max-w-3xl py-10 sm:py-14">
    <x-breadcrumbs :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Privacy Policy', 'url' => null]]" />

    <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Privacy Policy</h1>
    <p class="mt-2 text-sm text-slate-500">Last updated: {{ now()->format('d F Y') }}</p>

    <div class="prose-tool mt-6 space-y-6 text-slate-600">
        <p>
            Tokkucal ("we", "us") provides free online calculators and utility tools at this website. This policy explains
            what data is involved when you use the site and why.
        </p>

        <div>
            <h2 class="text-xl font-bold text-slate-900">No account, no stored calculations</h2>
            <p class="mt-2">
                Tokkucal does not require you to create an account or log in. The numbers you enter into a calculator, and
                the results shown, are not saved to a database or linked to you in any way.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-slate-900">Image and QR code tools</h2>
            <p class="mt-2">
                Images uploaded to the Image Compressor or Image Resizer are processed in memory on our server and returned
                to your browser in the same request. They are never written to disk or kept after the response is sent.
                The QR Code Generator runs entirely in your browser — the content you turn into a QR code is never sent to
                our servers at all.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-slate-900">Contact form</h2>
            <p class="mt-2">
                If you use the contact form, the name, email address, subject and message you provide are sent to us by
                email so we can respond. This information is not stored in a database or used for marketing.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-slate-900">Cookies</h2>
            <p class="mt-2">
                Tokkucal uses a session cookie to keep the site secure (for example, to prevent cross-site request forgery).
                This cookie does not identify you personally and expires automatically.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-slate-900">Analytics and advertising</h2>
            <p class="mt-2">
                We may use Google Analytics to understand overall traffic and which tools are popular, and Google AdSense
                to show ads that keep Tokkucal free. Both may use cookies or similar technologies to collect information
                such as your approximate location, device type and browsing behaviour across websites. Google's use of
                this data is governed by
                <a href="https://policies.google.com/technologies/partner-sites" target="_blank" rel="noopener noreferrer">Google's Privacy &amp; Terms</a>.
                You can control ad personalisation through
                <a href="https://adssettings.google.com" target="_blank" rel="noopener noreferrer">Google Ads Settings</a>.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-slate-900">Server logs</h2>
            <p class="mt-2">
                Like most websites, our server automatically records basic technical information for security and
                troubleshooting purposes — such as IP address, browser type and pages requested. These logs are used only
                to keep the service reliable and secure, and are not used to build a profile of individual visitors.
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-slate-900">Children's privacy</h2>
            <p class="mt-2">Tokkucal is a general-audience utility website and does not knowingly collect personal information from children.</p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-slate-900">Changes to this policy</h2>
            <p class="mt-2">We may update this policy from time to time. Changes will be posted on this page with an updated date.</p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-slate-900">Contact</h2>
            <p class="mt-2">
                Questions about this policy can be sent via our <a href="{{ route('contact') }}">Contact page</a>.
            </p>
        </div>
    </div>
</div>
@endsection
