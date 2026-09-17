<footer class="border-t border-[#d9b34a]/20 bg-[#0d0a08] py-10">
    <div class="mx-auto flex max-w-6xl flex-col items-center gap-4 px-6 text-center">
        <p class="font-display text-xs uppercase tracking-widest text-[#cbb98a]">
            {{ $data['hero']['name'] }} — {{ $data['hero']['class'] }}
        </p>

        <div class="flex items-center gap-5 text-sm">
            <a href="{{ $data['links']['linkedin'] }}" target="_blank" rel="noopener" class="nav-link">LinkedIn</a>
            @if($data['links']['github'])
                <a href="{{ $data['links']['github'] }}" target="_blank" rel="noopener" class="nav-link">GitHub</a>
            @endif
            <a href="mailto:{{ $data['links']['email'] }}" class="nav-link">Email</a>
        </div>

        <p class="text-xs text-[#cbb98a]/60">
            &copy; {{ date('Y') }} {{ $data['hero']['name'] }}. Ditempa dengan Laravel &amp; Tailwind.
        </p>
    </div>
</footer>
