@extends('layouts.app')

@section('content')
<div class="container-page flex flex-col items-center py-20 text-center sm:py-28">
    <p class="text-sm font-semibold text-indigo-600">403</p>
    <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Access denied</h1>
    <p class="mt-3 max-w-md text-slate-600">
        You don't have permission to view this page.
    </p>
    <div class="mt-8">
        <a href="{{ route('home') }}" class="btn-primary">Go to Homepage</a>
    </div>
</div>
@endsection
