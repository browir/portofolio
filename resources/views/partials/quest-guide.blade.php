<canvas id="weather-canvas" class="weather-canvas" aria-hidden="true"></canvas>

<div id="quest-guide" class="quest-guide" hidden>
    <div class="quest-guide-head">
        <span class="quest-guide-step font-display js-quest-step">QUEST 1/8</span>
        <span class="quest-guide-head-actions">
            <button type="button" class="quest-guide-journal-btn font-body" id="quest-guide-journal-btn">
                <x-icon name="document" class="h-3.5 w-3.5" /> Jurnal
            </button>
            <button type="button" class="quest-guide-exit font-body" id="quest-guide-exit">Keluar Adventure &times;</button>
        </span>
    </div>

    <div class="quest-guide-npc">
        <span class="quest-guide-portrait">
            <x-character-icon name="wira" class="h-9 w-9" />
        </span>
        <div class="quest-guide-bubble">
            <p class="quest-guide-npc-name font-display js-npc-name">WIRA</p>
            <p class="quest-guide-npc-line font-body js-npc-line">&ldquo;Selamat datang, Player.&rdquo;</p>
        </div>
    </div>

    <p class="quest-guide-title font-display js-quest-title">Gerbang Portofolio</p>
    <p class="quest-guide-text font-body js-quest-text">Perjalanan dimulai di sini, Player.</p>
    <button type="button" class="quest-guide-next font-display" id="quest-guide-next">LANJUTKAN QUEST &#9656;</button>
    <p class="quest-guide-keyhint font-body">&#8594; / Enter lanjut &nbsp;&bull;&nbsp; Esc keluar</p>
</div>

<div id="quest-journal" class="quest-journal" hidden>
    <div class="quest-journal-inner">
        <div class="quest-journal-head">
            <p class="quest-journal-title font-display">JURNAL PETUALANGAN</p>
            <button type="button" class="quest-journal-close" id="quest-journal-close" aria-label="Tutup">&times;</button>
        </div>
        <ul class="quest-journal-list js-journal-list"></ul>
    </div>
</div>

<div id="achievement-toast" class="achievement-toast" role="status" aria-live="polite">
    <x-icon name="medal" class="h-5 w-5 shrink-0 text-[#ffec27]" />
    <div>
        <p class="achievement-toast-title font-display">ACHIEVEMENT UNLOCKED</p>
        <p class="achievement-toast-sub font-body js-achievement-sub"></p>
    </div>
</div>
