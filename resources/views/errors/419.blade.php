@extends('layouts.app')

@section('content')
<div class="container-page flex flex-col items-center py-20 text-center sm:py-28">
    <p class="text-sm font-semibold text-indigo-600">419</p>
    <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Your session expired</h1>
    <p class="mt-3 max-w-md text-slate-600">
        This page was open for a while, so your session timed out for security. Please go back and try again.
    </p>
    <div class="mt-8 flex flex-wrap justify-center gap-3">
        <button type="button" onclick="window.history.back()" class="btn-secondary">Go Back</button>
        <a href="{{ route('home') }}" class="btn-primary">Go to Homepage</a>
    </div>
</div>
@endsection
