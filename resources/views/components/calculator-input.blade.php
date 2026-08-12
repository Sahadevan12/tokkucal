@props([
    'name',
    'label',
    'type' => 'number',
    'prefix' => null,
    'suffix' => null,
    'help' => null,
    'value' => null,
    'step' => 'any',
    'min' => null,
    'placeholder' => null,
    'required' => false,
])

<div>
    <label for="{{ $name }}" class="field-label">
        {{ $label }}
        @if ($required)
            <span class="text-red-600" aria-hidden="true">*</span>
        @endif
    </label>

    <div class="relative">
        @if ($prefix)
            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-500">{{ $prefix }}</span>
        @endif

        <input
            id="{{ $name }}"
            name="{{ $name }}"
            type="{{ $type }}"
            @if ($type === 'number') inputmode="decimal" @endif
            @if (!is_null($value)) value="{{ $value }}" @endif
            @if ($step !== null) step="{{ $step }}" @endif
            @if (!is_null($min)) min="{{ $min }}" @endif
            @if ($placeholder) placeholder="{{ $placeholder }}" @endif
            @if ($required) required aria-required="true" @endif
            {{ $attributes->merge(['class' => 'field-input'.($prefix ? ' pl-9' : '').($suffix ? ' pr-12' : ''), 'autocomplete' => 'off']) }}
            aria-describedby="{{ $help ? $name.'-help' : '' }} {{ $name }}-error"
        >

        @if ($suffix)
            <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-500">{{ $suffix }}</span>
        @endif
    </div>

    @if ($help)
        <p id="{{ $name }}-help" class="field-help">{{ $help }}</p>
    @endif

    <p id="{{ $name }}-error" class="field-error hidden" role="alert"></p>
</div>
