@props(['name', 'class' => 'h-6 w-6'])

@php
    $inner = match ($name) {
        'shield' => '<path d="M12 3.5c2.4 1.4 4.6 2 7 2.1.3 5.6-1.6 10.4-7 13.4-5.4-3-7.3-7.8-7-13.4 2.4-.1 4.6-.7 7-2.1Z"/><path d="M9.2 12.1l1.9 1.9 3.7-3.9"/>',

        'scroll' => '<path d="M6.5 4.5h9a2 2 0 0 1 2 2v13"/><path d="M6.5 4.5a2 2 0 0 0-2 2V17a2 2 0 0 0 2 2h11"/><path d="M9 9h6.5M9 12.5h6.5"/><circle cx="17.5" cy="19" r="1.6"/>',

        'gear-bot' => '<rect x="6" y="9.5" width="12" height="9" rx="2.2"/><path d="M12 9.5V6.2"/><circle cx="12" cy="4.6" r="1.3"/><path d="M4.3 13v3M19.7 13v3"/><circle cx="9.3" cy="13.6" r="1.1"/><circle cx="14.7" cy="13.6" r="1.1"/><path d="M9.8 16.8h4.4"/>',

        'pulse' => '<path d="M20 12.3h-3.4l-1.8-3.6-2.9 7.4-2-4.9-1.4 1.1H4"/><path d="M12 20.5c-4.4-2.7-8-5.8-8-9.9A4.6 4.6 0 0 1 12 7.3a4.6 4.6 0 0 1 8 3.3c0 4.1-3.6 7.2-8 9.9Z"/>',

        'chart' => '<path d="M4.5 19.5h15"/><rect x="6.3" y="12.5" width="2.6" height="7"/><rect x="10.7" y="8.5" width="2.6" height="11"/><rect x="15.1" y="4.8" width="2.6" height="14.7"/>',

        'printer' => '<path d="M7 8.5V4.5h10v4"/><rect x="4.5" y="8.5" width="15" height="7.2" rx="1.4"/><path d="M7 14.3h10v5.2H7z"/><circle cx="16.3" cy="11.2" r=".9"/>',

        'paw' => '<circle cx="8" cy="8.3" r="1.6"/><circle cx="12.4" cy="6.4" r="1.6"/><circle cx="16.8" cy="8.3" r="1.6"/><path d="M12.4 12.3c2.8 0 5.4 1.9 5.4 4.5 0 2-1.7 2.9-3.4 2.2-1.1-.4-2.8-.4-3.9 0-1.8.7-3.4-.2-3.4-2.2 0-2.6 2.5-4.5 5.3-4.5Z"/>',

        'medal' => '<circle cx="12" cy="14.3" r="4.8"/><path d="M12 11.3v6M9.8 13.2l2.2-2 2.2 2"/><path d="M9.3 10 7 4.5h3l2 4.3M14.7 10 17 4.5h-3l-2 4.3"/>',

        'ballot' => '<rect x="5" y="4.5" width="14" height="16" rx="1.6"/><path d="M8.3 9.5h7.4M8.3 12.7h7.4"/><path d="M8.6 16.5l1.5 1.5 2.6-2.9"/>',

        'castle' => '<path d="M5 20.5V9.8l2.2-1.9V5.4h2v1.6l1.3-1.1V4h2v1.9l1.3 1.1V5.4h2v2.5l2.2 1.9v10.7Z"/><path d="M9.6 20.5v-5.3h4.8v5.3"/>',

        'school' => '<path d="M4 10.5 12 6l8 4.5-8 4.5-8-4.5Z"/><path d="M7.5 12.3v4.4c0 1.2 2 2.3 4.5 2.3s4.5-1.1 4.5-2.3v-4.4"/><path d="M19 10.5v5.2"/>',

        'cap' => '<path d="M3.5 10 12 6l8.5 4-8.5 4-8.5-4Z"/><path d="M7 12.6v3.8c0 1.3 2.2 2.4 5 2.4s5-1.1 5-2.4v-3.8"/><path d="M20.5 10.6v4.6"/>',

        'raven' => '<path d="M4 14.5c1.5-3.8 4.6-6.3 8.4-6.3 4 0 7.2 2.8 8.3 6.6-1.6-.7-2.8-.6-3.6.2-1 1-.7 2.3.3 3.3-2 .6-3.6-.1-4.4-1.3-1 1.4-2.8 2-4.7 1.4 1-.9 1.3-2 .4-3.1-.9-1-2.4-1.2-4.7-.8Z"/><circle cx="14.6" cy="11.4" r=".7" fill="currentColor" stroke="none"/>',

        'compass' => '<circle cx="12" cy="12" r="8"/><path d="m14.8 9.2-1.6 4.4-4.4 1.6 1.6-4.4z"/>',

        'gem' => '<path d="M7 4.5h10l3.5 5L12 20.5 4.5 9.5Z"/><path d="M4.5 9.5h15M9.3 4.5 7.5 9.5 12 20.5l4.5-11-1.8-5"/>',
        default => '<circle cx="12" cy="12" r="8"/>',
    };
@endphp

<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="{{ $class }}">{!! $inner !!}</svg>
