<footer class="mt-16 border-t border-slate-200 bg-white">
    <div class="container-page grid grid-cols-2 gap-8 py-12 sm:grid-cols-2 lg:grid-cols-4">
        <div class="col-span-2 lg:col-span-1">
            <a href="{{ route('home') }}" class="text-lg font-extrabold text-slate-900">Tokkucal</a>
            <p class="mt-2 max-w-xs text-sm text-slate-500">{{ config('tokkucal.tagline') }}. Free, fast calculators and tools for everyday life in India.</p>
        </div>

        <div>
            <h3 class="text-sm font-semibold text-slate-900">Tools</h3>
            <ul class="mt-3 space-y-2 text-sm text-slate-500">
                @foreach ($navTools->take(6) as $tool)
                    <li><a href="{{ route($tool->slug) }}" class="hover:text-indigo-600">{{ $tool->name }}</a></li>
                @endforeach
            </ul>
        </div>

        <div>
            <h3 class="text-sm font-semibold text-slate-900">Categories</h3>
            <ul class="mt-3 space-y-2 text-sm text-slate-500">
                @foreach (config('tokkucal.categories') as $key => $label)
                    <li><a href="{{ route('home') }}#{{ $key }}-tools" class="hover:text-indigo-600">{{ $label }}</a></li>
                @endforeach
            </ul>
        </div>

        <div>
            <h3 class="text-sm font-semibold text-slate-900">Company</h3>
            <ul class="mt-3 space-y-2 text-sm text-slate-500">
                <li><a href="{{ route('about') }}" class="hover:text-indigo-600">About</a></li>
                <li><a href="{{ route('contact') }}" class="hover:text-indigo-600">Contact</a></li>
            </ul>

            <h3 class="mt-6 text-sm font-semibold text-slate-900">Legal</h3>
            <ul class="mt-3 space-y-2 text-sm text-slate-500">
                <li><a href="{{ route('privacy-policy') }}" class="hover:text-indigo-600">Privacy Policy</a></li>
                <li><a href="{{ route('terms') }}" class="hover:text-indigo-600">Terms</a></li>
                <li><a href="{{ route('disclaimer') }}" class="hover:text-indigo-600">Disclaimer</a></li>
            </ul>
        </div>
    </div>

    <div class="border-t border-slate-200">
        <div class="container-page flex flex-col items-center justify-between gap-2 py-6 text-xs text-slate-500 sm:flex-row">
            <p>&copy; {{ date('Y') }} Tokkucal. All rights reserved.</p>
            <p>Developed by {{ config('tokkucal.developer') }}</p>
        </div>
    </div>
</footer>
