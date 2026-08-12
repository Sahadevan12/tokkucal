@extends('layouts.app')

@section('content')
<div class="container-page max-w-2xl py-10 sm:py-14">
    <x-breadcrumbs :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Contact', 'url' => null]]" />

    <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Contact Us</h1>
    <p class="mt-3 text-slate-600">
        Found a bug, have feedback, or want to suggest a new tool? Send us a message and we'll get back to you.
    </p>

    @if (session('status'))
        <div class="mt-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('contact.send') }}" class="card mt-6 space-y-5 p-6 sm:p-8" novalidate>
        @csrf

        <div>
            <label for="name" class="field-label">Name <span class="text-red-600" aria-hidden="true">*</span></label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required class="field-input" aria-describedby="name-error">
            @error('name')
                <p id="name-error" class="field-error" role="alert">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="field-label">Email <span class="text-red-600" aria-hidden="true">*</span></label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required class="field-input" aria-describedby="email-error">
            @error('email')
                <p id="email-error" class="field-error" role="alert">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="subject" class="field-label">Subject <span class="text-red-600" aria-hidden="true">*</span></label>
            <input id="subject" name="subject" type="text" value="{{ old('subject') }}" required class="field-input" aria-describedby="subject-error">
            @error('subject')
                <p id="subject-error" class="field-error" role="alert">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="message" class="field-label">Message <span class="text-red-600" aria-hidden="true">*</span></label>
            <textarea id="message" name="message" rows="5" required class="field-input" aria-describedby="message-error">{{ old('message') }}</textarea>
            @error('message')
                <p id="message-error" class="field-error" role="alert">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn-primary w-full sm:w-auto">Send Message</button>
    </form>

    @if (config('tokkucal.contact_email'))
        <p class="mt-6 text-sm text-slate-500">
            You can also reach us directly at
            <a href="mailto:{{ config('tokkucal.contact_email') }}" class="text-indigo-600 hover:underline">{{ config('tokkucal.contact_email') }}</a>.
        </p>
    @endif
</div>
@endsection
