<div id="start-gate" class="start-gate">
    <div class="start-gate-inner">
        <p class="start-gate-kicker font-display">INSERT COIN</p>
        <h1 class="start-gate-title font-display">{{ strtoupper($data['hero']['name']) }}</h1>
        <p class="start-gate-sub font-body">{{ $data['hero']['class'] }}</p>
        <p class="start-gate-mission font-body">Satu portofolio, satu dunia untuk dijelajahi. Siap mulai petualangannya?</p>

        <button type="button" id="start-btn" class="start-btn font-display animate-flicker">START</button>

        <p class="start-gate-hint font-body" id="start-hint">Tekan START untuk memulai petualangan</p>
    </div>
</div>
