<section id="guild" class="px-6 py-16">
    <div class="mx-auto max-w-6xl">
        <h2 class="section-heading text-2xl uppercase text-[#f4d675] sm:text-3xl">Guild Hall</h2>
        <p class="mt-3 max-w-2xl text-sm text-[#cbb98a]">Pendidikan dan sertifikasi &mdash; scroll yang membuktikan pelatihan formal.</p>

        <div class="mt-10 grid grid-cols-1 gap-8 md:grid-cols-2">
            <div class="rpg-panel p-8">
                <h3 class="font-display text-sm uppercase tracking-widest text-[#cbb98a]">Pendidikan</h3>
                <div class="mt-4 space-y-5">
                    @foreach ($data['education'] as $edu)
                        <div class="border-b border-[#d9b34a]/15 pb-4 last:border-0 last:pb-0">
                            <p class="font-display text-base text-[#f4d675]">{{ $edu['title'] }}</p>
                            <p class="mt-1 text-sm text-[#ecdcb4]/85">{{ $edu['place'] }}</p>
                            <p class="mt-1 text-xs uppercase tracking-widest text-[#cbb98a]">{{ $edu['period'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rpg-panel p-8">
                <h3 class="font-display text-sm uppercase tracking-widest text-[#cbb98a]">Scroll Sertifikasi</h3>
                <div class="mt-4 space-y-4">
                    @foreach ($data['certifications'] as $cert)
                        <div class="flex items-start gap-3 border-b border-[#d9b34a]/15 pb-4 last:border-0 last:pb-0">
                            <span class="mt-0.5 text-lg">📜</span>
                            <div>
                                <p class="font-display text-sm text-[#f4d675]">{{ $cert['name'] }}</p>
                                <p class="mt-1 text-xs text-[#cbb98a]">{{ $cert['issuer'] }} &middot; {{ $cert['year'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
