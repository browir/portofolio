<section id="achievements" class="px-6 py-16">
    <div class="mx-auto max-w-6xl">
        <h2 class="section-heading text-2xl uppercase text-[#f4d675] sm:text-3xl">Achievements Unlocked</h2>
        <p class="mt-3 max-w-2xl text-sm text-[#cbb98a]">Proyek-proyek yang sudah dituntaskan, disimpan sebagai lencana pencapaian.</p>

        <div class="mt-10 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($data['achievements'] as $item)
                <a href="{{ $item['link'] ?? '#' }}"
                   @if(($item['link'] ?? '#') !== '#') target="_blank" rel="noopener" @endif
                   class="rpg-panel achievement-card block p-6">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full border border-[#d9b34a]/50 bg-[#d9b34a]/10 text-2xl">
                        {{ $item['badge'] }}
                    </div>
                    <h3 class="mt-4 font-display text-base text-[#f4d675]">{{ $item['title'] }}</h3>
                    @if(!empty($item['period']))
                        <p class="mt-0.5 text-[11px] uppercase tracking-widest text-[#cbb98a]">{{ $item['period'] }}</p>
                    @endif
                    <p class="mt-2 text-sm leading-relaxed text-[#ecdcb4]/85">{{ $item['description'] }}</p>

                    <div class="mt-4 flex flex-wrap gap-1.5">
                        @foreach ($item['stack'] as $tech)
                            <span class="rounded border border-[#d9b34a]/25 px-1.5 py-0.5 text-[10px] uppercase tracking-wide text-[#cbb98a]">
                                {{ $tech }}
                            </span>
                        @endforeach
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
