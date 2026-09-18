<section id="contact" class="px-6 py-16">
    <div class="mx-auto max-w-3xl">
        <h2 class="section-heading mx-auto text-center text-2xl uppercase text-[#fff7a0] sm:text-3xl">
            <span class="inline-flex items-center gap-3 align-middle">
                <x-icon name="mail" class="h-7 w-7 text-[#ffec27]" /> Send a Message
            </span>
        </h2>
        <p class="mt-3 text-center font-body text-lg text-[#83769c]">Punya proyek baru atau sekadar mau menyapa? Kirim pesan lewat form di bawah.</p>

        <div class="rpg-panel relative mt-10 p-8">
            @include('partials.corners')
            @if (session('status'))
                <div class="mb-6 border-2 border-[#5cffab]/40 bg-[#00e436]/10 px-4 py-3 font-body text-lg text-[#5cffab]">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('portfolio.contact') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block font-display text-xs uppercase tracking-widest text-[#83769c]">Nama</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="mt-2 w-full border-2 border-[#ffec27]/30 bg-[#0b0b14] px-4 py-2.5 font-body text-lg text-[#fff1e8] outline-none focus:border-[#ffec27] focus:shadow-[3px_3px_0_0_#ffec27]">
                    @error('name') <p class="mt-1 text-xs text-[#ff77a8]">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="block font-display text-xs uppercase tracking-widest text-[#83769c]">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                           class="mt-2 w-full border-2 border-[#ffec27]/30 bg-[#0b0b14] px-4 py-2.5 font-body text-lg text-[#fff1e8] outline-none focus:border-[#ffec27] focus:shadow-[3px_3px_0_0_#ffec27]">
                    @error('email') <p class="mt-1 text-xs text-[#ff77a8]">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="message" class="block font-display text-xs uppercase tracking-widest text-[#83769c]">Pesan</label>
                    <textarea name="message" id="message" rows="5" required
                              class="mt-2 w-full border-2 border-[#ffec27]/30 bg-[#0b0b14] px-4 py-2.5 font-body text-lg text-[#fff1e8] outline-none focus:border-[#ffec27] focus:shadow-[3px_3px_0_0_#ffec27]">{{ old('message') }}</textarea>
                    @error('message') <p class="mt-1 text-xs text-[#ff77a8]">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="btn-quest btn-primary w-full px-6 py-3 text-sm uppercase">
                    Kirim Pesan &rarr;
                </button>
            </form>
        </div>
    </div>
</section>
