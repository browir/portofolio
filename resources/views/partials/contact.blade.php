<section id="contact" class="px-6 py-16">
    <div class="mx-auto max-w-3xl">
        <h2 class="section-heading mx-auto text-center text-2xl uppercase text-[#f4d675] sm:text-3xl">
            <span class="inline-flex items-center gap-3 align-middle">
                <x-icon name="raven" class="h-7 w-7 text-[#d9b34a]" /> Send a Raven
            </span>
        </h2>
        <p class="mt-3 text-center text-sm text-[#cbb98a]">Punya quest baru atau sekadar mau menyapa? Kirim pesan lewat gulungan di bawah.</p>

        <div class="rpg-panel relative mt-10 p-8">
            @include('partials.corners')
            @if (session('status'))
                <div class="mb-6 rounded border border-[#4c9c72]/40 bg-[#2f6b4f]/10 px-4 py-3 text-sm text-[#4c9c72]">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('portfolio.contact') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block font-display text-xs uppercase tracking-widest text-[#cbb98a]">Nama</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="mt-2 w-full rounded border border-[#d9b34a]/30 bg-[#0d0a08] px-4 py-2.5 text-sm text-[#ecdcb4] outline-none focus:border-[#d9b34a] focus:ring-1 focus:ring-[#d9b34a]">
                    @error('name') <p class="mt-1 text-xs text-[#d1495b]">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="block font-display text-xs uppercase tracking-widest text-[#cbb98a]">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                           class="mt-2 w-full rounded border border-[#d9b34a]/30 bg-[#0d0a08] px-4 py-2.5 text-sm text-[#ecdcb4] outline-none focus:border-[#d9b34a] focus:ring-1 focus:ring-[#d9b34a]">
                    @error('email') <p class="mt-1 text-xs text-[#d1495b]">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="message" class="block font-display text-xs uppercase tracking-widest text-[#cbb98a]">Pesan</label>
                    <textarea name="message" id="message" rows="5" required
                              class="mt-2 w-full rounded border border-[#d9b34a]/30 bg-[#0d0a08] px-4 py-2.5 text-sm text-[#ecdcb4] outline-none focus:border-[#d9b34a] focus:ring-1 focus:ring-[#d9b34a]">{{ old('message') }}</textarea>
                    @error('message') <p class="mt-1 text-xs text-[#d1495b]">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="btn-quest btn-primary w-full rounded px-6 py-3 text-sm uppercase">
                    Kirim Gagak &rarr;
                </button>
            </form>
        </div>
    </div>
</section>
