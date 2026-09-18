<div id="xp-hud" class="xp-hud" role="button" tabindex="0" aria-expanded="false" aria-controls="xp-progress-panel">
    <div class="xp-hud-head">
        <span class="xp-hud-level font-display">
            <x-icon name="medal" class="mr-1 inline h-3 w-3 text-[#ffec27]" /><span class="js-xp-level">LVL 1</span>
        </span>
        <span class="xp-hud-count font-body js-xp-count">0/100 XP</span>
    </div>
    <div class="stat-track">
        <div class="stat-fill js-xp-fill" style="width: 0%"></div>
    </div>
    <p class="xp-hud-cta font-body">Klik untuk lihat progress</p>
</div>

<div id="xp-progress-panel" class="xp-progress-panel" hidden>
    <div class="xp-progress-head">
        <p class="xp-progress-title font-display js-progress-title">MENUJU LVL 2</p>
        <button type="button" class="xp-progress-close" id="xp-progress-close" aria-label="Tutup">&times;</button>
    </div>
    <p class="xp-progress-sub font-body js-progress-remaining">Butuh 100 XP lagi untuk naik level</p>
    <ul class="xp-progress-list js-progress-list"></ul>
</div>

<div id="xp-popup" class="xp-popup"></div>

<div id="level-up-toast" class="level-up-toast" role="status" aria-live="polite">
    <p class="title font-display">&#9733; LEVEL UP!</p>
    <p class="sub font-body"></p>
</div>
