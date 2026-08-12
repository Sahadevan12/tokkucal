@props(['name'])

@php
    $paths = [
        'receipt-percent' => '<path d="M6 3h12v18l-2.5-1.5L13 21l-2.5-1.5L8 21l-2-1.5V3Z"/><circle cx="10" cy="9" r="1.25"/><circle cx="14" cy="13" r="1.25"/><path d="m10 14 4-6"/>',
        'banknotes' => '<rect x="3" y="7" width="18" height="11" rx="2"/><circle cx="12" cy="12.5" r="2.25"/><path d="M6.5 7v11M17.5 7v11"/>',
        'percent-badge' => '<circle cx="12" cy="12" r="9"/><path d="m9 15 6-6"/><circle cx="9.75" cy="9" r="1"/><circle cx="14.25" cy="15" r="1"/>',
        'cake' => '<path d="M4 21v-7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v7Z"/><path d="M4 17.5c1.2.8 2.3.8 3.5 0s2.3-.8 3.5 0 2.3.8 3.5 0 2.3-.8 3.5 0"/><path d="M9 12V8M15 12V8"/><path d="M9 8c-.8 0-1.2-.9-.6-1.6C9 5.8 9 5 9 4M15 8c-.8 0-1.2-.9-.6-1.6.6-.6.6-1.4.6-2.4"/>',
        'wallet' => '<rect x="3" y="6" width="18" height="13" rx="2.5"/><path d="M3 10h13a2.5 2.5 0 0 1 0 5H3"/><circle cx="15.5" cy="12.5" r="1"/>',
        'tag' => '<path d="M11.5 3H5a2 2 0 0 0-2 2v6.5a2 2 0 0 0 .6 1.4l8.5 8.5a2 2 0 0 0 2.8 0l6.5-6.5a2 2 0 0 0 0-2.8l-8.5-8.5a2 2 0 0 0-1.4-.6Z"/><circle cx="8" cy="8" r="1.5"/>',
        'clipboard-check' => '<rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4V3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v1"/><path d="m8.5 13 2.3 2.3L15.5 11"/>',
        'photo' => '<rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="8.5" cy="9.5" r="1.75"/><path d="m4 17 5-5 3.5 3.5L17 11l4 4"/>',
        'arrows-pointing-out' => '<path d="M9 3H3v6M15 3h6v6M21 15v6h-6M3 15v6h6"/>',
        'qr-code' => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><path d="M14 14h3v3h-3zM14 20h2M20 17v3M17 20v0"/>',
        'search' => '<circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/>',
        'menu' => '<path d="M4 7h16M4 12h16M4 17h16"/>',
        'close' => '<path d="M6 6l12 12M18 6 6 18"/>',
        'chevron-down' => '<path d="m6 9 6 6 6-6"/>',
        'chevron-right' => '<path d="m9 6 6 6-6 6"/>',
        'check' => '<path d="m5 13 4 4L19 7"/>',
        'check-circle' => '<circle cx="12" cy="12" r="9"/><path d="m8 12.5 2.5 2.5L16 9.5"/>',
        'mail' => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 7 8 6 8-6"/>',
        'upload' => '<path d="M12 16V4M7 9l5-5 5 5"/><path d="M4 16v3a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-3"/>',
        'download' => '<path d="M12 4v12M7 11l5 5 5-5"/><path d="M4 16v3a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-3"/>',
        'trash' => '<path d="M5 7h14M9 7V5a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2m3 0-.8 12.1a2 2 0 0 1-2 1.9H8.8a2 2 0 0 1-2-1.9L6 7"/>',
        'link-external' => '<path d="M14 4h6v6M20 4 11 13"/><path d="M19 13v5a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h5"/>',
        'reset' => '<path d="M4 4v6h6"/><path d="M4.5 13a8 8 0 1 0 2-8.5L4 10"/>',
        'shield-check' => '<path d="M12 3l7 3v6c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6Z"/><path d="m8.5 12 2.3 2.3L15.5 9.5"/>',
        'bolt' => '<path d="M13 2 4 14h6l-1 8 9-12h-6l1-8Z"/>',
        'device-mobile' => '<rect x="7" y="2" width="10" height="20" rx="2"/><path d="M11 18h2"/>',
        'clock' => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.5 2"/>',
    ];

    $svg = $paths[$name] ?? '<circle cx="12" cy="12" r="9"/>';
@endphp

<svg {{ $attributes->merge(['class' => 'w-5 h-5', 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '1.6', 'stroke-linecap' => 'round', 'stroke-linejoin' => 'round', 'aria-hidden' => 'true']) }}>{!! $svg !!}</svg>
