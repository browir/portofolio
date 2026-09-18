@props(['name', 'class' => 'h-10 w-10'])

<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="{{ $class }}">
    @switch($name)
        @case('knight')
            <circle cx="16" cy="17" r="13" fill="#9aa7ba" />
            <path d="M16 2 19 9h-6Z" fill="#ff4d6d" />
            <rect x="7" y="15" width="18" height="6" fill="#1d2b53" />
            <rect x="10" y="16.4" width="3.2" height="3.2" fill="#7ef9ff" />
            <rect x="18.8" y="16.4" width="3.2" height="3.2" fill="#7ef9ff" />
            <rect x="11" y="25" width="10" height="3" fill="#ffec27" />
            @break

        @case('princess')
            <circle cx="16" cy="17" r="12" fill="#ffd9b3" />
            <circle cx="6" cy="16" r="4" fill="#8a5a2b" />
            <circle cx="26" cy="16" r="4" fill="#8a5a2b" />
            <ellipse cx="9.3" cy="20.6" rx="1.7" ry="1.1" fill="#ff9fc0" opacity="0.85" />
            <ellipse cx="22.7" cy="20.6" rx="1.7" ry="1.1" fill="#ff9fc0" opacity="0.85" />
            <circle cx="12" cy="17.4" r="1.6" fill="#1d2b53" />
            <circle cx="20" cy="17.4" r="1.6" fill="#1d2b53" />
            <path d="M9.6 15 8.3 13.6M22.4 15 23.7 13.6" stroke="#1d2b53" stroke-width="1" fill="none" stroke-linecap="round" />
            <path d="M12 23q4 3 8 0" stroke="#1d2b53" stroke-width="1.4" fill="none" stroke-linecap="round" />
            <path d="M8 25q8 4 16 0v3q-8 3-16 0Z" fill="#ff4d8d" />
            <path d="M9 9 9 4 12.5 7 16 2 19.5 7 23 4 23 9Z" fill="#ffd60a" />
            <circle cx="16" cy="5.5" r="1" fill="#ff77a8" />
            @break

        @case('dragon')
            <circle cx="16" cy="18" r="12" fill="#ff004d" />
            <path d="M7 9 12 1 13 10Z" fill="#7a0026" />
            <path d="M25 9 20 1 19 10Z" fill="#7a0026" />
            <path d="M8 24q8 5 16 0v3q-8 4-16 0Z" fill="#c40041" />
            <path d="M11 16 14.5 18 11 20.4Z" fill="#ffec27" />
            <path d="M21 16 17.5 18 21 20.4Z" fill="#ffec27" />
            <circle cx="13" cy="24" r="0.9" fill="#5c0018" />
            <circle cx="19" cy="24" r="0.9" fill="#5c0018" />
            @break

        @default
            <circle cx="16" cy="16" r="12" fill="#8b8bb8" />
    @endswitch
</svg>
