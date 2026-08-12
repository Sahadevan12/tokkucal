<script type="application/json" id="tools-index">
    {!! $navTools->map(fn ($tool) => [
        'name' => $tool->name,
        'url' => route($tool->slug),
        'short_description' => $tool->short_description,
        'category' => $tool->category,
    ])->values()->toJson() !!}
</script>

<header class="sticky top-0 z-40 border-b border-slate-200 bg-white/95 backdrop-blur supports-[backdrop-filter]:bg-white/80">
    <div class="container-page flex h-16 items-center justify-between gap-4">
        <a href="{{ route('home') }}" class="flex shrink-0 items-center gap-2 text-lg font-extrabold text-slate-900">
            <img src="{{ asset('favicon.svg') }}" alt="" class="h-8 w-8" width="32" height="32">
            Tokkucal
        </a>

        <nav aria-label="Primary" class="hidden items-center gap-6 text-sm font-medium text-slate-600 lg:flex">
            <a href="{{ route('home') }}" class="hover:text-indigo-600">Home</a>
            <a href="{{ route('home') }}#popular-tools" class="hover:text-indigo-600">Popular Tools</a>

            <div class="relative">
                <button type="button" data-dropdown-toggle aria-controls="categories-menu" aria-expanded="false" class="flex items-center gap-1 hover:text-indigo-600">
                    Categories
                    <x-icon name="chevron-down" class="h-4 w-4" />
                </button>
                <div id="categories-menu" class="absolute left-0 top-full z-50 mt-2 hidden w-48 rounded-xl border border-slate-200 bg-white p-2 shadow-lg">
                    @foreach (config('tokkucal.categories') as $key => $label)
                        <a href="{{ route('home') }}#{{ $key }}-tools" class="block rounded-lg px-3 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-indigo-600">{{ $label }}</a>
                    @endforeach
                </div>
            </div>

            <a href="{{ route('about') }}" class="hover:text-indigo-600">About</a>
        </nav>

        <div class="hidden lg:block">
            <div class="relative w-64" data-tool-search>
                <label for="desktop-tool-search" class="sr-only">Search tools</label>
                <x-icon name="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" />
                <input
                    id="desktop-tool-search"
                    data-tool-search-input
                    type="search"
                    placeholder="Search tools…"
                    autocomplete="off"
                    class="field-input min-h-10 pl-9"
                >
                <div data-tool-search-results class="absolute z-50 mt-2 hidden w-full divide-y divide-slate-100 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-lg"></div>
            </div>
        </div>

        <button
            type="button"
            data-mobile-nav-toggle
            aria-expanded="false"
            aria-controls="mobile-nav-panel"
            aria-label="Open menu"
            class="flex h-11 w-11 items-center justify-center rounded-lg text-slate-700 hover:bg-slate-100 lg:hidden"
        >
            <x-icon name="menu" class="h-6 w-6" />
        </button>
    </div>
</header>

<div id="mobile-nav-panel" data-mobile-nav-panel class="hidden border-b border-slate-200 bg-white lg:hidden">
    <div class="container-page space-y-4 py-4">
        <div class="relative" data-tool-search>
            <label for="mobile-tool-search" class="sr-only">Search tools</label>
            <x-icon name="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" />
            <input
                id="mobile-tool-search"
                data-tool-search-input
                type="search"
                placeholder="Search tools…"
                autocomplete="off"
                class="field-input pl-9"
            >
            <div data-tool-search-results class="absolute z-50 mt-2 hidden w-full divide-y divide-slate-100 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-lg"></div>
        </div>

        <nav aria-label="Mobile" class="flex flex-col divide-y divide-slate-100 text-base font-medium text-slate-700">
            <a href="{{ route('home') }}" class="min-h-11 py-3">Home</a>
            <a href="{{ route('home') }}#popular-tools" class="min-h-11 py-3">Popular Tools</a>
            @foreach (config('tokkucal.categories') as $key => $label)
                <a href="{{ route('home') }}#{{ $key }}-tools" class="min-h-11 py-3 pl-4 text-sm text-slate-600">{{ $label }}</a>
            @endforeach
            <a href="{{ route('about') }}" class="min-h-11 py-3">About</a>
        </nav>
    </div>
</div>
