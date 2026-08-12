@extends('layouts.app')

@section('content')
<div class="container-page flex flex-col items-center py-20 text-center sm:py-28">
    <p class="text-sm font-semibold text-indigo-600">404</p>
    <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Page not found</h1>
    <p class="mt-3 max-w-md text-slate-600">
        The page you're looking for doesn't exist or may have moved. Try one of the links below.
    </p>
    <div class="mt-8 flex flex-wrap justify-center gap-3">
        <a href="{{ route('home') }}" class="btn-primary">Go to Homepage</a>
        <a href="{{ route('home') }}#popular-tools" class="btn-secondary">Browse Tools</a>
    </div>
</div>
@endsection
