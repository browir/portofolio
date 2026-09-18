<section id="stats" class="px-6 py-16">
    <div class="mx-auto max-w-6xl">
        <h2 class="section-heading text-2xl uppercase text-[#fff7a0] sm:text-3xl">Skill Meter</h2>
        <p class="mt-3 max-w-2xl font-body text-lg text-[#83769c]">Statistik kemampuan teknis, dikumpulkan dari puluhan proyek dan latihan bertahun-tahun.</p>

        <div class="mt-10 grid grid-cols-1 gap-x-10 gap-y-6 md:grid-cols-2">
            @foreach ($data['stats'] as $stat)
                <div>
                    <div class="mb-1.5 flex items-baseline justify-between">
                        <span class="font-body text-lg uppercase tracking-wide text-[#fff1e8]">{{ $stat['name'] }}</span>
                        <span class="font-display text-xs text-[#fff7a0]">{{ $stat['value'] }}%</span>
                    </div>
                    <div class="stat-track">
                        <div class="stat-fill js-stat-fill" data-value="{{ $stat['value'] }}" style="width: 0%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
