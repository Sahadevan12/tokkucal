@php
    $position ??= 'default';
    $adSlot ??= null;
@endphp

@if (config('services.adsense.enabled') && config('services.adsense.client_id'))
    <div class="my-2 flex justify-center overflow-hidden" data-ad-position="{{ $position }}">
        <ins
            class="adsbygoogle"
            style="display:block;width:100%"
            data-ad-client="{{ config('services.adsense.client_id') }}"
            @if ($adSlot) data-ad-slot="{{ $adSlot }}" @endif
            data-ad-format="auto"
            data-full-width-responsive="true"
        ></ins>
    </div>
    @push('scripts')
        <script>
            (window.adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    @endpush
@else
    {{-- Development placeholder — keeps ad-slot spacing visible before AdSense is approved/enabled. --}}
    <div class="my-2 flex min-h-24 items-center justify-center rounded-xl border-2 border-dashed border-slate-200 bg-slate-50 text-xs font-medium tracking-wide text-slate-400" data-ad-position="{{ $position }}">
        AD PLACEHOLDER
    </div>
@endif
