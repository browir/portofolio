<section id="achievements" class="px-6 py-16">
    <div class="mx-auto max-w-6xl">
        <h2 class="section-heading text-2xl uppercase text-[#fff7a0] sm:text-3xl">Achievements Unlocked</h2>
        <p class="mt-3 max-w-2xl font-body text-lg text-[#83769c]">Proyek-proyek yang sudah dituntaskan, disimpan sebagai lencana pencapaian.</p>

        <div class="mt-10 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($data['achievements'] as $item)
                <a href="{{ $item['link'] ?? '#' }}"
                   @if(($item['link'] ?? '#') !== '#') target="_blank" rel="noopener" @endif
                   class="rpg-panel achievement-card relative block p-6 {{ $loop->first ? 'sm:col-span-2 lg:col-span-2' : '' }}">
                    @include('partials.corners')

                    <div class="icon-badge h-12 w-12">
                        <x-icon :name="$item['badge']" class="h-6 w-6" />
                    </div>
                    <h3 class="mt-4 font-body text-xl text-[#fff7a0]">{{ $item['title'] }}</h3>
                    @if(!empty($item['period']))
                        <p class="mt-0.5 text-[11px] uppercase tracking-widest text-[#83769c]">{{ $item['period'] }}</p>
                    @endif
                    <p class="mt-2 font-body text-lg leading-relaxed text-[#fff1e8]/85">{{ $item['description'] }}</p>

                    <div class="mt-4 flex flex-wrap gap-1.5">
                        @foreach ($item['stack'] as $tech)
                            <span class="border-2 border-[#ffec27]/25 px-1.5 py-0.5 text-[10px] uppercase tracking-wide text-[#83769c]">
                                {{ $tech }}
                            </span>
                        @endforeach
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
