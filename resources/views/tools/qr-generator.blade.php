@extends('layouts.app')

@section('content')
<div class="container-page py-8 sm:py-10">
    <x-breadcrumbs :items="$breadcrumbs" />

    <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">QR Code Generator</h1>
    <p class="mt-3 max-w-2xl text-slate-600">{{ $tool->description }}</p>

    <div class="mt-8 grid gap-8 lg:grid-cols-3 lg:items-start">
        <div class="space-y-6 lg:col-span-2">
            <div class="card p-6 sm:p-8">
                <div class="grid grid-cols-2 gap-1 rounded-xl bg-slate-100 p-1 sm:grid-cols-5" role="tablist" aria-label="QR code content type">
                    <button type="button" data-qr-type="url" class="qr-type-btn rounded-lg px-3 py-2.5 text-sm font-semibold transition" aria-pressed="true">URL</button>
                    <button type="button" data-qr-type="text" class="qr-type-btn rounded-lg px-3 py-2.5 text-sm font-semibold transition" aria-pressed="false">Text</button>
                    <button type="button" data-qr-type="email" class="qr-type-btn rounded-lg px-3 py-2.5 text-sm font-semibold transition" aria-pressed="false">Email</button>
                    <button type="button" data-qr-type="phone" class="qr-type-btn rounded-lg px-3 py-2.5 text-sm font-semibold transition" aria-pressed="false">Phone</button>
                    <button type="button" data-qr-type="wifi" class="qr-type-btn rounded-lg px-3 py-2.5 text-sm font-semibold transition" aria-pressed="false">Wi-Fi</button>
                </div>

                <div class="mt-6 space-y-5" data-qr-panel="url">
                    <x-calculator-input name="qr_url" type="url" label="Website URL" placeholder="https://example.com" />
                </div>

                <div class="mt-6 hidden space-y-5" data-qr-panel="text">
                    <div>
                        <label for="qr_text" class="field-label">Text</label>
                        <textarea id="qr_text" rows="3" class="field-input" placeholder="Any text"></textarea>
                    </div>
                </div>

                <div class="mt-6 hidden space-y-5" data-qr-panel="email">
                    <x-calculator-input name="qr_email_to" type="email" label="Email Address" placeholder="name@example.com" />
                    <x-calculator-input name="qr_email_subject" type="text" label="Subject (optional)" />
                </div>

                <div class="mt-6 hidden space-y-5" data-qr-panel="phone">
                    <x-calculator-input name="qr_phone" type="tel" label="Phone Number" placeholder="+91 98765 43210" />
                </div>

                <div class="mt-6 hidden space-y-5" data-qr-panel="wifi">
                    <x-calculator-input name="qr_wifi_ssid" type="text" label="Network Name (SSID)" />
                    <x-calculator-input name="qr_wifi_password" type="text" label="Password" />
                    <div>
                        <label for="qr_wifi_encryption" class="field-label">Security</label>
                        <select id="qr_wifi_encryption" class="field-input max-w-48">
                            <option value="WPA">WPA/WPA2</option>
                            <option value="WEP">WEP</option>
                            <option value="nopass">None (open network)</option>
                        </select>
                    </div>
                </div>

                <div class="mt-8 border-t border-slate-200 pt-6">
                    <p class="text-sm font-semibold text-slate-900">Appearance</p>
                    <div class="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-4">
                        <div>
                            <label for="qr_size" class="field-label">Size (px)</label>
                            <select id="qr_size" class="field-input">
                                <option value="200">200</option>
                                <option value="300" selected>300</option>
                                <option value="400">400</option>
                                <option value="500">500</option>
                            </select>
                        </div>
                        <div>
                            <label for="qr_margin" class="field-label">Margin</label>
                            <select id="qr_margin" class="field-input">
                                <option value="0">None</option>
                                <option value="2" selected>Small</option>
                                <option value="4">Medium</option>
                                <option value="6">Large</option>
                            </select>
                        </div>
                        <div>
                            <label for="qr_fg_color" class="field-label">Foreground</label>
                            <input type="color" id="qr_fg_color" value="#0f172a" class="field-input h-11 p-1">
                        </div>
                        <div>
                            <label for="qr_bg_color" class="field-label">Background</label>
                            <input type="color" id="qr_bg_color" value="#ffffff" class="field-input h-11 p-1">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card flex flex-col items-center gap-5 p-6 sm:p-8" aria-live="polite">
                <div id="qr-preview" class="flex min-h-56 w-full items-center justify-center rounded-xl bg-slate-50 p-4">
                    <canvas id="qr-canvas"></canvas>
                </div>
                <p id="qr-error" class="field-error hidden" role="alert"></p>
                <div class="flex flex-wrap justify-center gap-3">
                    <button type="button" id="qr-download-png" class="btn-primary">
                        <x-icon name="download" class="h-4 w-4" /> Download PNG
                    </button>
                    <button type="button" id="qr-download-svg" class="btn-secondary">
                        <x-icon name="download" class="h-4 w-4" /> Download SVG
                    </button>
                </div>
            </div>

            @include('layouts.partials.ad', ['position' => 'qr-generator-mid'])

            <x-seo-content title="About the QR Code Generator">
                <x-slot:howToUse>
                    <ol class="list-decimal space-y-1.5 pl-5">
                        <li>Choose what the QR code should contain: a URL, plain text, an email, a phone number or Wi-Fi details.</li>
                        <li>Fill in the fields — the QR preview updates automatically.</li>
                        <li>Adjust size, margin and colours if needed.</li>
                        <li>Download as PNG or SVG.</li>
                    </ol>
                </x-slot:howToUse>

                <x-slot:explanation>
                    <p>
                        This QR code is generated entirely in your browser using JavaScript — the text, link or Wi-Fi details you enter are
                        never sent to our servers. Scanning a Wi-Fi QR code lets a phone camera join the network directly without typing the
                        password, and an email or phone QR code opens the device's mail or dialer app pre-filled.
                    </p>
                </x-slot:explanation>
            </x-seo-content>

            <x-faq :items="[
                ['question' => 'Is the data I enter uploaded anywhere?', 'answer' => 'No. The QR code is generated locally in your browser using JavaScript. Nothing you type is sent to our servers.'],
                ['question' => 'What is the difference between the PNG and SVG download?', 'answer' => 'PNG is a fixed-resolution image, good for most uses. SVG is a vector format that stays sharp at any size, which is better if you plan to print the QR code very large.'],
                ['question' => 'Will the Wi-Fi QR code share my password with anyone who scans it?', 'answer' => 'Yes — anyone who scans a Wi-Fi QR code can join that network, so only share it with people you trust with your Wi-Fi password.'],
            ]" />
        </div>

        <aside class="space-y-6">
            @include('layouts.partials.ad', ['position' => 'qr-generator-sidebar'])
            <x-related-tools :slugs="['image-compressor', 'image-resizer']" />
        </aside>
    </div>
</div>
@endsection

@push('scripts')
    @vite('resources/js/tools/qr-generator.js')
@endpush
