<footer class="border-t-4 border-[#ffec27] bg-[#0b0b14] py-10">
    <div class="mx-auto flex max-w-6xl flex-col items-center gap-4 px-6 text-center">
        <p class="font-body text-xl uppercase tracking-widest text-[#83769c]">
            {{ $data['hero']['name'] }} — {{ $data['hero']['class'] }}
        </p>

        <div class="flex items-center gap-5 font-body text-lg">
            <a href="{{ $data['links']['linkedin'] }}" target="_blank" rel="noopener" class="nav-link">LinkedIn</a>
            @if($data['links']['github'])
                <a href="{{ $data['links']['github'] }}" target="_blank" rel="noopener" class="nav-link">GitHub</a>
            @endif
            @if($data['links']['instagram'] ?? null)
                <a href="{{ $data['links']['instagram'] }}" target="_blank" rel="noopener" class="nav-link">Instagram</a>
            @endif
            <a href="mailto:{{ $data['links']['email'] }}" class="nav-link">Email</a>
        </div>

        <p class="text-xs text-[#83769c]/60">
            &copy; {{ date('Y') }} {{ $data['hero']['name'] }}. Dibangun dengan Laravel &amp; Tailwind.
        </p>
    </div>
</footer>
