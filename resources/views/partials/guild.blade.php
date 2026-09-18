<section id="education" class="px-6 py-16">
    <div class="mx-auto max-w-6xl">
        <h2 class="section-heading text-2xl uppercase text-[#fff7a0] sm:text-3xl">Education &amp; Certifications</h2>
        <p class="mt-3 max-w-2xl font-body text-lg text-[#83769c]">Pendidikan dan sertifikasi &mdash; bukti pelatihan formal yang telah diselesaikan.</p>

        <div class="mt-10 grid grid-cols-1 gap-8 md:grid-cols-2">
            <div class="rpg-panel relative p-8">
                @include('partials.corners')
                <h3 class="flex items-center gap-2 font-display text-sm uppercase tracking-widest text-[#83769c]">
                    <x-icon name="cap" class="h-4 w-4 text-[#ffec27]" /> Pendidikan
                </h3>
                <div class="mt-4 space-y-5">
                    @foreach ($data['education'] as $edu)
                        <div class="border-b-2 border-[#ffec27]/15 pb-4 last:border-0 last:pb-0">
                            <p class="font-body text-xl text-[#fff7a0]">{{ $edu['title'] }}</p>
                            <p class="mt-1 font-body text-lg text-[#fff1e8]/85">{{ $edu['place'] }}</p>
                            <p class="mt-1 text-xs uppercase tracking-widest text-[#83769c]">{{ $edu['period'] }}</p>
                            @if(!empty($edu['honors']))
                                <div class="mt-3 flex flex-wrap gap-1.5">
                                    @foreach ($edu['honors'] as $honor)
                                        <span class="border-2 border-[#00e436]/50 bg-[#00e436]/10 px-2 py-1 text-[11px] text-[#5cffab]">
                                            {{ $honor }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rpg-panel relative p-8">
                @include('partials.corners')
                <h3 class="flex items-center gap-2 font-display text-sm uppercase tracking-widest text-[#83769c]">
                    <x-icon name="document" class="h-4 w-4 text-[#ffec27]" /> Sertifikasi
                </h3>
                <div class="mt-4 max-h-[26rem] space-y-4 overflow-y-auto pr-1">
                    @foreach ($data['certifications'] as $cert)
                        <div class="flex items-start gap-3 border-b-2 border-[#ffec27]/15 pb-4 last:border-0 last:pb-0">
                            <div class="icon-badge mt-0.5 h-8 w-8 shrink-0">
                                <x-icon name="document" class="h-4 w-4" />
                            </div>
                            <div>
                                <p class="font-body text-lg text-[#fff7a0]">{{ $cert['name'] }}</p>
                                <p class="mt-1 text-xs text-[#83769c]">{{ $cert['issuer'] }} &middot; {{ $cert['year'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
