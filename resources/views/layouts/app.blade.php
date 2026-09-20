<!doctype html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $data['hero']['name'] }} — {{ $data['hero']['class'] }}</title>
    <meta name="description" content="{{ $data['hero']['tagline'] }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=VT323&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-body antialiased selection:bg-[#ffec27] selection:text-[#1d2b53]">

    @include('partials.start-gate')
    @include('partials.character-select')
    @include('partials.mode-select')
    @include('partials.quest-guide')

    <div id="scroll-progress" class="fixed top-0 left-0 h-[5px] w-0 z-[60] border-b-2 border-[#0b0b14]"></div>

    @include('partials.nav')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    @include('partials.xp-hud')

</body>
</html>
