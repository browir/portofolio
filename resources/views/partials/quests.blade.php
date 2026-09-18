<section id="experience" class="px-6 py-16">
    <div class="mx-auto max-w-6xl">
        <h2 class="section-heading text-2xl uppercase text-[#fff7a0] sm:text-3xl">Mission Log</h2>
        <p class="mt-3 max-w-2xl font-body text-lg text-[#83769c]">Riwayat pengalaman kerja, dicatat sebagai misi yang telah dituntaskan.</p>

        <div class="relative mt-12">
            <div class="quest-line absolute left-[4px] top-2 bottom-2 w-1 md:left-1/2 md:-translate-x-1/2"></div>

            <div class="space-y-10">
                @foreach ($data['quests'] as $i => $quest)
                    <div class="relative flex flex-col md:flex-row md:items-start md:even:flex-row-reverse">
                        <div class="quest-node absolute left-0 top-2.5 h-3 w-3 rotate-45 bg-[#ffec27] md:left-1/2 md:-translate-x-1/2"></div>

                        <div class="w-full pl-10 md:w-1/2 md:px-10">
                            <div class="rpg-panel achievement-card relative p-6">
                                @include('partials.corners')
                                <div class="mb-2 flex flex-wrap items-center gap-3">
                                    <span class="badge-rank px-2 py-0.5 text-[10px]">{{ $quest['difficulty'] }}</span>
                                    <span class="text-xs uppercase tracking-widest text-[#83769c]">{{ $quest['period'] }}</span>
                                </div>
                                <h3 class="font-body text-2xl text-[#fff7a0]">{{ $quest['title'] }}</h3>
                                <p class="mt-0.5 font-body text-lg text-[#83769c]">Client: {{ $quest['giver'] }}</p>
                                <p class="mt-3 font-body text-lg leading-relaxed text-[#fff1e8]/90">{{ $quest['description'] }}</p>

                                @if(!empty($quest['rewards']))
                                    <div class="mt-4 flex flex-wrap gap-2">
                                        @foreach ($quest['rewards'] as $reward)
                                            <span class="border-2 border-[#00e436]/50 bg-[#00e436]/10 px-2 py-1 text-[11px] text-[#5cffab]">
                                                {{ $reward }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
