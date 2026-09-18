<section id="about" class="px-6 py-16">
    <div class="mx-auto max-w-6xl">
        <h2 class="section-heading text-2xl uppercase text-[#fff7a0] sm:text-3xl">About Me</h2>

        <div class="mt-10 grid grid-cols-1 gap-8 md:grid-cols-3">
            <div class="rpg-panel relative p-8 md:col-span-2">
                @include('partials.corners')
                <h3 class="font-display text-sm uppercase tracking-widest text-[#83769c]">Bio</h3>
                <p class="mt-4 font-body text-xl leading-relaxed text-[#fff1e8]/90">
                    {{ $data['about']['lore'] }}
                </p>
            </div>

            <div class="rpg-panel relative p-8">
                @include('partials.corners')
                <h3 class="font-display text-sm uppercase tracking-widest text-[#83769c]">Quick Info</h3>
                <dl class="mt-4 space-y-3 font-body text-lg">
                    @foreach ($data['about']['facts'] as $fact)
                        <div class="flex items-center justify-between border-b-2 border-[#ffec27]/15 pb-2">
                            <dt class="text-[#83769c]">{{ $fact['label'] }}</dt>
                            <dd class="font-medium text-[#fff7a0]">{{ $fact['value'] }}</dd>
                        </div>
                    @endforeach
                </dl>
            </div>
        </div>
    </div>
</section>
