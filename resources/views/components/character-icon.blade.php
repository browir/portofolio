@props(['name', 'class' => 'h-10 w-10'])

<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {{ match(true) { $name === 'dragon' => '40', default => '50' } }} 32" class="{{ $class }} character-sprite">
    @switch($name)
        @case('knight')
            {{-- shield --}}
            <ellipse cx="6" cy="10" rx="4.2" ry="5.8" fill="#1d2b53" stroke="#ffd60a" stroke-width="1" />
            <path d="M6 5v10M1.5 10h9" stroke="#ffd60a" stroke-width="1" />
            {{-- horse mount: legs grouped in two diagonal pairs so they can
                 animate as an alternating trot cycle --}}
            <g class="mount-leg mount-leg-a">
                <rect x="11" y="25" width="2.4" height="6" fill="#6b4a2b" />
                <rect x="26" y="25" width="2.4" height="6" fill="#6b4a2b" />
            </g>
            <g class="mount-leg mount-leg-b">
                <rect x="16" y="25" width="2.4" height="6" fill="#6b4a2b" />
                <rect x="31" y="25" width="2.4" height="6" fill="#6b4a2b" />
            </g>
            <ellipse cx="22" cy="22.5" rx="13.5" ry="6" fill="#a9713f" />
            <path class="mount-tail" d="M9 19q-5 3-3 10" stroke="#6b4a2b" stroke-width="2.4" fill="none" stroke-linecap="round" />
            <g class="mount-head">
                <path d="M31 22 33 11q.4-2 1.8-1l4 2.3q1 .6 0 1.2l-2.6 1.5 1.8 1q1 .6-.1 1.1l-3.2 1.4-1.2 4Z" fill="#a9713f" />
                <path d="M34.3 10.3 36 6.8 37 10.8Z" fill="#6b4a2b" />
            </g>
            {{-- knight head --}}
            <circle cx="19" cy="12" r="8.5" fill="#9aa7ba" />
            <path class="knight-plume" d="M19 2 21 7h-4Z" fill="#ff4d6d" />
            <rect x="13.5" y="10.3" width="11" height="4" fill="#1d2b53" />
            <rect class="knight-eye" x="15.5" y="11.2" width="2.1" height="2.1" fill="#7ef9ff" />
            <rect class="knight-eye" x="21" y="11.2" width="2.1" height="2.1" fill="#7ef9ff" />
            <rect x="14.5" y="17" width="9" height="2" fill="#ffec27" />
            {{-- sword, held up beside the knight's own shoulder; swings in
                 time with the trot, with a glint sliding down the blade --}}
            <g class="knight-sword">
                <path d="M25 18 31 4 32.3 4.6 26.3 18.6Z" fill="#c9d3e0" />
                <path class="knight-glint" d="M26.5 15 30.6 5.4 31.3 5.7 27.2 15.3Z" fill="#ffffff" />
                <path d="M23.5 17 27.5 15 28.5 17 24.5 19Z" fill="#8a5a2b" />
            </g>
            @break

        @case('princess')
            {{-- guard escort: marches alongside, spear bobbing with each step --}}
            <g class="princess-spear">
                <rect x="8" y="2" width="1.4" height="17" fill="#8a5a2b" />
                <path d="M7.2 2 8.7 0 10.2 2Z" fill="#c9d3e0" />
            </g>
            <rect x="2.5" y="9" width="6" height="3" fill="#1d2b53" />
            <circle cx="5.5" cy="7" r="3.4" fill="#9aa7ba" />
            <rect x="3.3" y="12" width="4.4" height="6.5" fill="#5b6a86" />
            <rect class="mount-leg mount-leg-a" x="2.7" y="18.5" width="2.2" height="5" fill="#3d4a5e" />
            <rect class="mount-leg mount-leg-b" x="6.1" y="18.5" width="2.2" height="5" fill="#3d4a5e" />
            {{-- carriage: wheels grouped with a spoke so rotation reads
                 clearly rather than a plain circle spinning in place --}}
            <g class="carriage-wheel">
                <circle cx="16" cy="27" r="4" fill="#3a2a1a" />
                <circle cx="16" cy="27" r="1.6" fill="#c9a86a" />
                <path d="M16 23.5v7M12.5 27h7" stroke="#c9a86a" stroke-width="0.8" />
            </g>
            <g class="carriage-wheel">
                <circle cx="32" cy="27" r="4" fill="#3a2a1a" />
                <circle cx="32" cy="27" r="1.6" fill="#c9a86a" />
                <path d="M32 23.5v7M28.5 27h7" stroke="#c9a86a" stroke-width="0.8" />
            </g>
            <g class="carriage-body">
                <path d="M9 14h30l-3 12H12Z" fill="#ff77a8" />
                <path d="M9 14h30v3H9Z" fill="#ffd60a" />
                <circle cx="24" cy="20.5" r="3" fill="#ff4d8d" />
                {{-- princess head: rides the carriage, so it shares the bounce --}}
                <circle cx="24" cy="10" r="7.2" fill="#ffd9b3" />
                <circle cx="18" cy="9.4" r="2.4" fill="#8a5a2b" />
                <circle cx="30" cy="9.4" r="2.4" fill="#8a5a2b" />
                <ellipse cx="20" cy="12.2" rx="1" ry="0.66" fill="#ff9fc0" opacity="0.85" />
                <ellipse cx="28" cy="12.2" rx="1" ry="0.66" fill="#ff9fc0" opacity="0.85" />
                <circle class="blink-eye" cx="21.6" cy="10.2" r="0.96" fill="#1d2b53" />
                <circle class="blink-eye" cx="26.4" cy="10.2" r="0.96" fill="#1d2b53" />
                <path d="M19.8 8.8 18.8 7.9M28.2 8.8 29.2 7.9" stroke="#1d2b53" stroke-width="0.6" fill="none" stroke-linecap="round" />
                <path d="M21.6 14q2.4 1.8 4.8 0" stroke="#1d2b53" stroke-width="0.9" fill="none" stroke-linecap="round" />
                {{-- crown drawn last so it isn't hidden under the head circle --}}
                <path d="M20.4 4.6 20.4 2 22.5 3.8 24 1 25.5 3.8 27.6 2 27.6 4.6Z" fill="#ffd60a" />
                <circle cx="24" cy="2.8" r="0.7" fill="#ff77a8" />
                <path class="crown-sparkle" d="M24 0 24.7 1.9 26.6 2.6 24.7 3.3 24 5.2 23.3 3.3 21.4 2.6 23.3 1.9Z" fill="#ffffff" />
            </g>
            @break

        @case('dragon')
            {{-- wings drawn first so the head naturally hides their roots --}}
            <path class="character-wing" d="M26 15 37 6 32 17 38 18 28 23Z" fill="#c40041" />
            <path class="character-wing" d="M14 15 3 6 8 17 2 18 12 23Z" fill="#c40041" />
            <circle cx="20" cy="18" r="11" fill="#ff004d" />
            <path class="dragon-horn" d="M11 9 16 1 17 10Z" fill="#7a0026" />
            <path class="dragon-horn" d="M29 9 24 1 23 10Z" fill="#7a0026" />
            <path d="M12 24q8 5 16 0v3q-8 4-16 0Z" fill="#c40041" />
            <path class="blink-eye" d="M15 16 18.5 18 15 20.4Z" fill="#ffec27" />
            <path class="blink-eye" d="M25 16 21.5 18 25 20.4Z" fill="#ffec27" />
            <circle cx="17" cy="24" r="0.9" fill="#5c0018" />
            <circle cx="23" cy="24" r="0.9" fill="#5c0018" />
            {{-- fire breath: puffs out of the jaw on a slow cycle, so the
                 sprite does something every few seconds instead of only
                 looping the same flap forever --}}
            <g class="dragon-flame">
                <path d="M20 26.5 24.5 31.8 15.5 31.8Z" fill="#ff9d3d" />
                <path d="M20 28 22.6 32 17.4 32Z" fill="#ffec27" />
            </g>
            @break

        @case('wira')
            {{-- shirt / shoulders --}}
            <path d="M13 32 15 23q1.4-3 5-3h10q3.6 0 5 3l2 9Z" fill="#29adff" />
            <path d="M21 20h8l-1.4 5h-5.2Z" fill="#12365c" />
            {{-- neck --}}
            <rect x="22" y="16" width="6" height="5" fill="#e8b48c" />
            {{-- head --}}
            <circle cx="25" cy="11" r="8" fill="#f3c9a0" />
            {{-- short hair --}}
            <path d="M17 10.5q-.3-7.5 8-7.5t8 7.5q0 1.6-.6 2.6-.6-4-4-4.8-2 2.8-6.6 3.2-2.6.2-3.6 2.2-1-1.3-1.2-3.2Z" fill="#2b2016" />
            {{-- headphones, a little dev signifier; the pads pulse in turn --}}
            <path d="M17.5 12q-1-9 7.5-9t7.5 9" fill="none" stroke="#1d2b53" stroke-width="1.6" stroke-linecap="round" />
            <rect x="15.3" y="10.5" width="3.6" height="6" rx="1.4" fill="#1d2b53" />
            <rect x="31.1" y="10.5" width="3.6" height="6" rx="1.4" fill="#1d2b53" />
            <rect class="wira-led" x="15.9" y="11.3" width="2.4" height="4.4" rx="1" fill="#ffec27" />
            <rect class="wira-led wira-led-b" x="31.7" y="11.3" width="2.4" height="4.4" rx="1" fill="#ffec27" />
            {{-- eyes blink; the mouth switches to an open shape while he is
                 delivering a line, so the quest dialogue has a talking head --}}
            <circle class="blink-eye" cx="22.2" cy="12.2" r="1" fill="#1d2b53" />
            <circle class="blink-eye" cx="27.8" cy="12.2" r="1" fill="#1d2b53" />
            <path class="wira-mouth-idle" d="M22.6 16q2.4 1.5 4.8 0" stroke="#8a5a34" stroke-width="0.8" fill="none" stroke-linecap="round" />
            <ellipse class="wira-mouth-talk" cx="25" cy="16.6" rx="1.7" ry="1.4" fill="#8a5a34" />
            @break

        @default
            <circle cx="16" cy="16" r="12" fill="#8b8bb8" />
    @endswitch
</svg>
