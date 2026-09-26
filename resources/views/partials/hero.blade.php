@php
    // "Equipped" slots read from the skill list itself, so the hero never
    // drifts out of sync with the Skill Meter section below.
    $equipped = collect($data['stats'])->sortByDesc('value')->take(3);
@endphp

<section id="top" class="relative overflow-hidden px-6 pb-20 pt-16 md:pt-24">
    <div class="hero-backdrop" aria-hidden="true">
        <span class="hero-stars"></span>
        <span class="hero-floor"></span>
    </div>

    <div class="relative mx-auto grid max-w-6xl grid-cols-1 items-start gap-12 md:grid-cols-12">

        <div class="md:col-span-7">
            <p class="hero-status font-display">{{ $data['hero']['status'] }}</p>

            <h1 class="hero-name font-display">{{ $data['hero']['name'] }}</h1>

            <p class="hero-class font-body">
                <span class="hero-lv font-display">LV {{ $data['hero']['level'] }}</span>
                {{ $data['hero']['title'] }} &mdash; {{ $data['hero']['class'] }}
            </p>

            <p class="hero-bio font-body">{{ $data['hero']['tagline'] }}<span class="hero-caret"></span></p>

            <ul class="hero-menu">
                <li>
                    <a href="#contact" class="hero-menu-item font-display">
                        <span class="hero-menu-label">Hubungi Saya</span>
                        <span class="hero-menu-hint font-body">Portal Komunikasi</span>
                    </a>
                </li>
                <li>
                    <a href="{{ $data['links']['linkedin'] }}" target="_blank" rel="noopener" class="hero-menu-item font-display">
                        <span class="hero-menu-label">LinkedIn</span>
                        <span class="hero-menu-hint font-body">Riwayat &amp; rekomendasi</span>
                    </a>
                </li>
                <li>
                    <a href="{{ $data['links']['github'] }}" target="_blank" rel="noopener" class="hero-menu-item font-display">
                        <span class="hero-menu-label">GitHub</span>
                        <span class="hero-menu-hint font-body">Kode sumber</span>
                    </a>
                </li>
                @if($data['links']['cv'])
                    <li>
                        <a href="{{ $data['links']['cv'] }}" target="_blank" rel="noopener" class="hero-menu-item font-display">
                            <span class="hero-menu-label">Unduh CV</span>
                            <span class="hero-menu-hint font-body">Versi kertas</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>

        {{-- Status window: a JRPG character sheet, portrait sprite and all. --}}
        <div class="md:col-span-5">
            <div class="rpg-panel relative p-6 pt-7">
                @include('partials.corners')
                <span class="hero-window-tab font-display">STATUS</span>

                <div class="flex items-center gap-4">
                    <span class="hero-portrait">
                        <x-character-icon name="wira" class="h-auto w-full" />
                    </span>
                    <span class="min-w-0">
                        <span class="hero-portrait-name font-body">{{ $data['hero']['name'] }}</span>
                        <span class="hero-portrait-class font-display">{{ $data['hero']['title'] }}</span>
                    </span>
                </div>

                <div class="hero-params">
                    <p class="hero-param">
                        <span class="hero-param-label font-body">Perusahaan</span>
                        <span class="hero-param-dots"></span>
                        <span class="hero-param-value font-body">{{ $data['hero']['company'] }}</span>
                    </p>
                    <p class="hero-param">
                        <span class="hero-param-label font-body">Wilayah</span>
                        <span class="hero-param-dots"></span>
                        <span class="hero-param-value font-body">{{ $data['hero']['location'] }}</span>
                    </p>
                    <p class="hero-param">
                        <span class="hero-param-label font-body">Pengalaman</span>
                        <span class="hero-param-dots"></span>
                        <span class="hero-param-value font-body">{{ now()->year - 2020 }}+ tahun</span>
                    </p>
                </div>

                <p class="hero-slots-label font-display">EQUIPPED</p>
                <div class="hero-slots">
                    @foreach($equipped as $skill)
                        <span class="hero-slot font-body">{{ $skill['name'] }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
