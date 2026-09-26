<div id="character-select" class="character-select" hidden>
    <div class="character-select-inner">
        <p class="character-select-kicker font-display">PILIH KARAKTER</p>
        <p class="character-select-sub font-body">Teman kecilmu selama menjelajah portofolio ini</p>

        <div class="character-grid">
            <button type="button" class="character-card" data-character="knight">
                <x-character-icon name="knight" class="h-14 w-14" />
                <span class="character-name font-display">KNIGHT</span>
                <span class="character-tagline font-body">Pelindung setia baris kode</span>
            </button>
            <button type="button" class="character-card" data-character="princess">
                <x-character-icon name="princess" class="h-14 w-14" />
                <span class="character-name font-display">PRINCESS</span>
                <span class="character-tagline font-body">Anggun &amp; penuh strategi</span>
            </button>
            <button type="button" class="character-card" data-character="dragon">
                <x-character-icon name="dragon" class="h-14 w-14" />
                <span class="character-name font-display">DRAGON</span>
                <span class="character-tagline font-body">Garang &amp; tak kenal takut</span>
            </button>
        </div>

        {{-- Confirm step: picking a card only auditions the character (its
             sprite springs to life and it says its line); the visitor has to
             press the button to actually take it along. --}}
        <div class="character-confirm" id="character-confirm" hidden>
            <p class="character-quote font-body js-character-quote" aria-live="polite"></p>
            <button type="button" class="btn-quest btn-primary character-confirm-btn font-display" id="character-confirm-btn">
                PILIH KARAKTER &#9656;
            </button>
        </div>
    </div>
</div>

<div id="pet-companion" class="pet-companion animate-float-slow" hidden>
    <div class="pet-bubble" id="pet-bubble"></div>
    <button type="button" id="pet-avatar" class="pet-avatar" aria-label="Teman kamu">
        <span class="pet-icon" data-character="knight"><x-character-icon name="knight" class="h-9 w-9" /></span>
        <span class="pet-icon" data-character="princess"><x-character-icon name="princess" class="h-9 w-9" /></span>
        <span class="pet-icon" data-character="dragon"><x-character-icon name="dragon" class="h-9 w-9" /></span>
    </button>
</div>
