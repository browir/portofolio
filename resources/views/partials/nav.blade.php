@php
    $navItems = [
        '#character' => 'Character',
        '#stats' => 'Stats',
        '#quests' => 'Quest Log',
        '#achievements' => 'Achievements',
        '#guild' => 'Guild Hall',
        '#contact' => 'Contact',
    ];
    $nameParts = explode(' ', $data['hero']['name']);
    $navName = count($nameParts) > 2
        ? $nameParts[0].' '.end($nameParts)
        : $data['hero']['name'];
@endphp

<header class="sticky top-0 z-50 border-b border-[#d9b34a]/20 bg-[#0d0a08]/85 backdrop-blur-md">
    <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
        <a href="#top" class="flex items-center gap-2 font-display text-lg tracking-widest text-[#f4d675]">
            <x-icon name="gem" class="h-5 w-5 text-[#d9b34a]" />
            {{ strtoupper($navName) }}
        </a>

        <nav class="hidden items-center gap-8 text-sm md:flex">
            @foreach ($navItems as $href => $label)
                <a href="{{ $href }}" class="nav-link font-display text-xs uppercase">{{ $label }}</a>
            @endforeach
        </nav>

        <a href="{{ $data['links']['linkedin'] }}" target="_blank" rel="noopener"
           class="btn-quest btn-primary hidden rounded px-4 py-2 text-xs uppercase sm:inline-block">
            LinkedIn
        </a>

        <button id="nav-toggle" class="text-[#f4d675] md:hidden" aria-label="Buka menu">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <nav id="nav-mobile" class="hidden flex-col gap-1 border-t border-[#d9b34a]/20 px-6 py-4 md:hidden">
        @foreach ($navItems as $href => $label)
            <a href="{{ $href }}" class="nav-link py-2 font-display text-xs uppercase">{{ $label }}</a>
        @endforeach
    </nav>
</header>
