<section id="top" class="relative overflow-hidden px-6 pb-20 pt-16 md:pt-24">
    <!-- ambient glow -->
    <div class="pointer-events-none absolute inset-0">
        <div class="absolute -left-32 top-10 h-72 w-72 rounded-full bg-[#2f6b4f] opacity-20 blur-3xl"></div>
        <div class="absolute right-0 top-40 h-72 w-72 rounded-full bg-[#9c2b3c] opacity-20 blur-3xl"></div>
    </div>

    <div class="relative mx-auto grid max-w-6xl grid-cols-1 items-center gap-12 md:grid-cols-5">

        <div class="md:col-span-3">
            <p class="mb-4 inline-block rounded border border-[#d9b34a]/40 bg-[#d9b34a]/10 px-3 py-1 font-display text-xs uppercase tracking-widest text-[#f4d675]">
                {{ $data['hero']['status'] }}
            </p>

            <h1 class="font-display text-4xl font-bold leading-tight text-[#f4d675] sm:text-5xl md:text-6xl">
                {{ $data['hero']['name'] }}
            </h1>
            <p class="mt-3 font-display text-lg uppercase tracking-widest text-[#cbb98a]">
                {{ $data['hero']['title'] }} &middot; {{ $data['hero']['class'] }}
            </p>

            <p class="mt-6 max-w-xl text-base leading-relaxed text-[#ecdcb4]/90 sm:text-lg">
                {{ $data['hero']['tagline'] }}
            </p>

            <div class="mt-8 flex flex-wrap gap-4">
                <a href="#contact" class="btn-quest btn-primary rounded px-6 py-3 text-sm uppercase">
                    Mulai Quest &rarr;
                </a>
                <a href="{{ $data['links']['linkedin'] }}" target="_blank" rel="noopener"
                   class="btn-quest btn-ghost rounded px-6 py-3 text-sm uppercase">
                    Lihat LinkedIn
                </a>
                @if($data['links']['cv'])
                    <a href="{{ $data['links']['cv'] }}" target="_blank" rel="noopener"
                       class="btn-quest btn-ghost rounded px-6 py-3 text-sm uppercase">
                        Unduh CV
                    </a>
                @endif
            </div>
        </div>

        <!-- Character sheet card -->
        <div class="md:col-span-2">
            <div class="rpg-panel animate-float-slow relative p-6">
                @include('partials.corners')
                <div class="flex items-center gap-4">
                    <div class="avatar-ring flex h-20 w-20 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-[#2f6b4f] to-[#1b140d] font-display text-3xl text-[#f4d675]">
                        {{ $data['hero']['avatar_initial'] }}
                    </div>
                    <div>
                        <p class="font-display text-lg text-[#f4d675]">{{ $data['hero']['name'] }}</p>
                        <p class="text-xs uppercase tracking-widest text-[#cbb98a]">Lvl {{ $data['hero']['level'] }} &middot; {{ $data['hero']['class'] }}</p>
                    </div>
                </div>

                <div class="mt-5 space-y-2 text-sm">
                    <div class="flex justify-between border-b border-[#d9b34a]/15 py-1.5">
                        <span class="text-[#cbb98a]">Guild</span>
                        <span class="text-[#ecdcb4]">{{ $data['hero']['guild'] }}</span>
                    </div>
                    <div class="flex justify-between border-b border-[#d9b34a]/15 py-1.5">
                        <span class="text-[#cbb98a]">Wilayah</span>
                        <span class="text-[#ecdcb4]">{{ $data['hero']['location'] }}</span>
                    </div>
                    <div class="flex justify-between py-1.5">
                        <span class="text-[#cbb98a]">Tahun Pengalaman</span>
                        <span class="text-[#ecdcb4]">{{ now()->year - 2020 }}+ tahun</span>
                    </div>
                </div>

                <div class="mt-5">
                    <div class="mb-1 flex justify-between text-[10px] uppercase tracking-widest text-[#cbb98a]">
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
