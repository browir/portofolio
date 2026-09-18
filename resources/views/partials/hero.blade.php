<section id="top" class="relative overflow-hidden px-6 pb-20 pt-16 md:pt-24">
    <!-- ambient glow -->
    <div class="pointer-events-none absolute inset-0">
        <div class="absolute -left-32 top-10 h-72 w-72 rounded-full bg-[#00e436] opacity-20 blur-3xl"></div>
        <div class="absolute right-0 top-40 h-72 w-72 rounded-full bg-[#ff004d] opacity-20 blur-3xl"></div>
    </div>

    <div class="relative mx-auto grid max-w-6xl grid-cols-1 items-center gap-12 md:grid-cols-5">

        <div class="md:col-span-3">
            <p class="mb-4 inline-block border-2 border-[#ffec27] bg-[#ffec27]/10 px-3 py-1 font-display text-[10px] uppercase tracking-widest text-[#fff7a0]">
                {{ $data['hero']['status'] }}
            </p>

            <h1 class="font-display text-3xl font-bold leading-relaxed text-[#fff7a0] sm:text-4xl md:text-5xl">
                {{ $data['hero']['name'] }}
            </h1>
            <p class="mt-4 font-body text-2xl uppercase tracking-widest text-[#83769c]">
                {{ $data['hero']['title'] }} &middot; {{ $data['hero']['class'] }}
            </p>

            <p class="mt-6 max-w-xl font-body text-xl leading-relaxed text-[#fff1e8]/90">
                {{ $data['hero']['tagline'] }}
            </p>

            <div class="mt-8 flex flex-wrap gap-5">
                <a href="#contact" class="btn-quest btn-primary px-6 py-3 text-sm uppercase">
                    Hubungi Saya &rarr;
                </a>
                <a href="{{ $data['links']['linkedin'] }}" target="_blank" rel="noopener"
                   class="btn-quest btn-ghost px-6 py-3 text-sm uppercase">
                    Lihat LinkedIn
                </a>
                @if($data['links']['cv'])
                    <a href="{{ $data['links']['cv'] }}" target="_blank" rel="noopener"
                       class="btn-quest btn-ghost px-6 py-3 text-sm uppercase">
                        Unduh CV
                    </a>
                @endif
            </div>
        </div>

        <!-- Player card -->
        <div class="md:col-span-2">
            <div class="rpg-panel animate-float-slow relative p-6">
                @include('partials.corners')
                <div class="flex items-center gap-4">
                    <div class="avatar-ring flex h-20 w-20 shrink-0 items-center justify-center bg-gradient-to-br from-[#00e436] to-[#1d2b53] font-display text-2xl text-[#fff7a0]">
                        {{ $data['hero']['avatar_initial'] }}
                    </div>
                    <div>
                        <p class="font-body text-2xl text-[#fff7a0]">{{ $data['hero']['name'] }}</p>
                        <p class="text-xs uppercase tracking-widest text-[#83769c]">Lvl {{ $data['hero']['level'] }} &middot; {{ $data['hero']['class'] }}</p>
                    </div>
                </div>

                <div class="mt-5 space-y-2 text-sm">
                    <div class="flex justify-between border-b border-[#ffec27]/15 py-1.5">
                        <span class="text-[#83769c]">Perusahaan</span>
                        <span class="text-[#fff1e8]">{{ $data['hero']['company'] }}</span>
                    </div>
                    <div class="flex justify-between border-b border-[#ffec27]/15 py-1.5">
                        <span class="text-[#83769c]">Wilayah</span>
                        <span class="text-[#fff1e8]">{{ $data['hero']['location'] }}</span>
                    </div>
                    <div class="flex justify-between py-1.5">
                        <span class="text-[#83769c]">Tahun Pengalaman</span>
                        <span class="text-[#fff1e8]">{{ now()->year - 2020 }}+ tahun</span>
                    </div>
                </div>

                <div class="mt-5">
                    <div class="mb-1 flex justify-between text-[10px] uppercase tracking-widest text-[#83769c]">
                        <span>XP</span>
                        <span>Menuju Lvl {{ $data['hero']['level'] + 1 }}</span>
                    </div>
                    <div class="stat-track">
                        <div class="stat-fill" style="width: 72%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
