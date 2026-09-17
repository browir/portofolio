<section id="character" class="px-6 py-16">
    <div class="mx-auto max-w-6xl">
        <h2 class="section-heading text-2xl uppercase text-[#f4d675] sm:text-3xl">Character Lore</h2>

        <div class="mt-10 grid grid-cols-1 gap-8 md:grid-cols-3">
            <div class="rpg-panel p-8 md:col-span-2">
                <h3 class="font-display text-sm uppercase tracking-widest text-[#cbb98a]">Backstory</h3>
                <p class="mt-4 text-base leading-relaxed text-[#ecdcb4]/90">
                    {{ $data['about']['lore'] }}
                </p>
            </div>

            <div class="rpg-panel p-8">
                <h3 class="font-display text-sm uppercase tracking-widest text-[#cbb98a]">Character Info</h3>
                <dl class="mt-4 space-y-3 text-sm">
                    @foreach ($data['about']['facts'] as $fact)
                        <div class="flex items-center justify-between border-b border-[#d9b34a]/15 pb-2">
                            <dt class="text-[#cbb98a]">{{ $fact['label'] }}</dt>
                            <dd class="font-medium text-[#f4d675]">{{ $fact['value'] }}</dd>
                        </div>
                    @endforeach
                </dl>
            </div>
        </div>
    </div>
</section>
