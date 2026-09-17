<section id="quests" class="px-6 py-16">
    <div class="mx-auto max-w-6xl">
        <h2 class="section-heading text-2xl uppercase text-[#f4d675] sm:text-3xl">Quest Log</h2>
        <p class="mt-3 max-w-2xl text-sm text-[#cbb98a]">Riwayat pengalaman kerja, dicatat sebagai quest yang telah dituntaskan.</p>

        <div class="relative mt-12">
            <div class="quest-line absolute left-[7px] top-2 bottom-2 w-px md:left-1/2 md:-translate-x-1/2"></div>

            <div class="space-y-10">
                @foreach ($data['quests'] as $i => $quest)
                    <div class="relative flex flex-col md:flex-row md:items-start md:even:flex-row-reverse">
                        <div class="quest-node absolute left-0 top-2.5 h-3 w-3 rotate-45 bg-[#d9b34a] md:left-1/2 md:-translate-x-1/2"></div>

                        <div class="w-full pl-10 md:w-1/2 md:px-10 md:pl-10 md:even:pl-0 md:even:pr-10">
                            <div class="rpg-panel achievement-card relative p-6">
                                @include('partials.corners')
                                <div class="mb-2 flex flex-wrap items-center gap-3">
                                    <span class="badge-rank rounded px-2 py-0.5 text-[10px]">{{ $quest['difficulty'] }}</span>
                                    <span class="text-xs uppercase tracking-widest text-[#cbb98a]">{{ $quest['period'] }}</span>
                                </div>
                                <h3 class="font-display text-lg text-[#f4d675]">{{ $quest['title'] }}</h3>
                                <p class="mt-0.5 text-sm text-[#cbb98a]">Quest Giver: {{ $quest['giver'] }}</p>
                                <p class="mt-3 text-sm leading-relaxed text-[#ecdcb4]/90">{{ $quest['description'] }}</p>

                                @if(!empty($quest['rewards']))
                                    <div class="mt-4 flex flex-wrap gap-2">
                                        @foreach ($quest['rewards'] as $reward)
                                            <span class="rounded border border-[#2f6b4f]/50 bg-[#2f6b4f]/10 px-2 py-1 text-[11px] text-[#4c9c72]">
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
