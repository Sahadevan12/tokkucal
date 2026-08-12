@props(['tool'])

<a href="{{ route($tool->slug) }}" class="card group flex items-start gap-4 p-5 transition hover:border-indigo-300 hover:shadow-md">
    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition">
        <x-icon :name="$tool->icon" class="w-6 h-6" />
    </span>
    <span class="min-w-0">
        <span class="block font-semibold text-slate-900">{{ $tool->name }}</span>
        <span class="mt-0.5 block text-sm text-slate-500 line-clamp-2">{{ $tool->short_description }}</span>
    </span>
</a>
