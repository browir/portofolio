<section id="stats" class="px-6 py-16">
    <div class="mx-auto max-w-6xl">
        <h2 class="section-heading text-2xl uppercase text-[#f4d675] sm:text-3xl">Ability Stats</h2>
        <p class="mt-3 max-w-2xl text-sm text-[#cbb98a]">Statistik kemampuan teknis, dikumpulkan dari puluhan quest dan latihan bertahun-tahun.</p>

        <div class="mt-10 grid grid-cols-1 gap-x-10 gap-y-6 md:grid-cols-2">
            @foreach ($data['stats'] as $stat)
                <div>
                    <div class="mb-1.5 flex items-baseline justify-between">
                        <span class="font-display text-sm uppercase tracking-wide text-[#ecdcb4]">{{ $stat['name'] }}</span>
                        <span class="font-display text-xs text-[#f4d675]">{{ $stat['value'] }}%</span>
                    </div>
                    <div class="stat-track">
                        <div class="stat-fill js-stat-fill" data-value="{{ $stat['value'] }}" style="width: 0%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
