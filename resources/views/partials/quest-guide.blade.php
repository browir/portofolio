<canvas id="weather-canvas" class="weather-canvas" aria-hidden="true"></canvas>

<div id="quest-guide" class="quest-guide" hidden>
    <div class="quest-guide-head">
        <span class="quest-guide-step font-display js-quest-step">QUEST 1/8</span>
        <button type="button" class="quest-guide-exit font-body" id="quest-guide-exit">Keluar Adventure &times;</button>
    </div>

    <div class="quest-guide-npc">
        <span class="quest-guide-portrait">
            <span class="npc-icon" data-character="knight"><x-character-icon name="knight" class="h-9 w-9" /></span>
            <span class="npc-icon" data-character="princess"><x-character-icon name="princess" class="h-9 w-9" /></span>
            <span class="npc-icon" data-character="dragon"><x-character-icon name="dragon" class="h-9 w-9" /></span>
        </span>
        <div class="quest-guide-bubble">
            <p class="quest-guide-npc-name font-display js-npc-name">KNIGHT</p>
            <p class="quest-guide-npc-line font-body js-npc-line">&ldquo;Selamat datang, Player.&rdquo;</p>
        </div>
    </div>

    <p class="quest-guide-title font-display js-quest-title">Gerbang Portofolio</p>
    <p class="quest-guide-text font-body js-quest-text">Perjalanan dimulai di sini, Player.</p>
    <button type="button" class="quest-guide-next font-display" id="quest-guide-next">LANJUTKAN QUEST &#9656;</button>
</div>
