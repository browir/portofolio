import './bootstrap';

// Shared 8-bit sound engine: lazily opens a single AudioContext on the first
// user gesture (autoplay policies require it) and synthesizes short blips
// with oscillators plus filtered-noise ambience loops, so no audio files
// need to be shipped. Mute preference persists per-browser.
const Sound = (function () {
    const STORAGE_KEY = 'portfolio_sound_muted';
    let ctx = null;
    let muted = false;
    let ambient = null;
    let ambientType = null;

    try {
        muted = localStorage.getItem(STORAGE_KEY) === '1';
    } catch (e) {
        // ignore unavailable storage
    }

    function resume() {
        if (!ctx) {
            const AudioContextClass = window.AudioContext || window.webkitAudioContext;
            if (!AudioContextClass) return null;
            ctx = new AudioContextClass();
        }
        if (ctx.state === 'suspended') ctx.resume();
        return ctx;
    }

    function beep({ freq, duration, type, gain, slideTo }) {
        if (muted) return;
        const audioCtx = resume();
        if (!audioCtx) return;

        const osc = audioCtx.createOscillator();
        const amp = audioCtx.createGain();
        osc.type = type;
        osc.frequency.setValueAtTime(freq, audioCtx.currentTime);
        if (slideTo) osc.frequency.exponentialRampToValueAtTime(slideTo, audioCtx.currentTime + duration);

        amp.gain.setValueAtTime(gain, audioCtx.currentTime);
        amp.gain.exponentialRampToValueAtTime(0.0001, audioCtx.currentTime + duration);

        osc.connect(amp).connect(audioCtx.destination);
        osc.start();
        osc.stop(audioCtx.currentTime + duration);
    }

    function noiseBuffer(audioCtx) {
        const buffer = audioCtx.createBuffer(1, audioCtx.sampleRate * 2, audioCtx.sampleRate);
        const data = buffer.getChannelData(0);
        for (let i = 0; i < data.length; i += 1) data[i] = Math.random() * 2 - 1;
        return buffer;
    }

    // Ambient weather beds are just filtered noise -- lowpassed hiss reads as
    // rain, a thin highpassed hush as autumn wind -- so each Adventure Mode
    // quest stop gets its own atmosphere with no audio assets to ship.
    const ambientProfiles = {
        rain: { filter: 'lowpass', freq: 1400, q: 0.6, gain: 0.05 },
        snow: { filter: 'lowpass', freq: 500, q: 0.4, gain: 0.025 },
        autumn: { filter: 'highpass', freq: 800, q: 0.3, gain: 0.03 },
        sunny: { filter: 'bandpass', freq: 2200, q: 1.2, gain: 0.015 },
    };

    function stopAmbient() {
        if (!ambient) return;
        const { source, gain } = ambient;
        if (ctx) {
            gain.gain.exponentialRampToValueAtTime(0.0001, ctx.currentTime + 0.6);
            window.setTimeout(() => {
                try {
                    source.stop();
                } catch (e) {
                    // already stopped
                }
            }, 650);
        }
        ambient = null;
        ambientType = null;
    }

    function playAmbient(type) {
        if (type === ambientType) return;
        stopAmbient();
        if (!type || muted || !ambientProfiles[type]) return;

        const audioCtx = resume();
        if (!audioCtx) return;
        const profile = ambientProfiles[type];

        const source = audioCtx.createBufferSource();
        source.buffer = noiseBuffer(audioCtx);
        source.loop = true;

        const filter = audioCtx.createBiquadFilter();
        filter.type = profile.filter;
        filter.frequency.value = profile.freq;
        filter.Q.value = profile.q;

        const gain = audioCtx.createGain();
        gain.gain.setValueAtTime(0.0001, audioCtx.currentTime);
        gain.gain.exponentialRampToValueAtTime(profile.gain, audioCtx.currentTime + 1.2);

        source.connect(filter).connect(gain).connect(audioCtx.destination);
        source.start();

        ambient = { source, gain };
        ambientType = type;
    }

    function setMuted(next) {
        muted = next;
        try {
            localStorage.setItem(STORAGE_KEY, muted ? '1' : '0');
        } catch (e) {
            // ignore unavailable storage
        }
        if (muted) stopAmbient();
        else if (ambientType) playAmbient(ambientType);
    }

    // A short ascending fanfare for finishing every quest.
    function victory() {
        if (muted) return;
        const notes = [392.0, 523.25, 659.25, 783.99, 1046.5];
        notes.forEach((f, i) => {
            window.setTimeout(() => beep({ freq: f, duration: 0.22, type: 'square', gain: 0.06 }), i * 110);
        });
    }

    return {
        isMuted: () => muted,
        setMuted,
        playAmbient,
        stopAmbient,
        victory,
        blip: () => beep({ freq: 520, duration: 0.05, type: 'square', gain: 0.05 }),
        confirm: () => beep({ freq: 660, duration: 0.14, type: 'square', gain: 0.07, slideTo: 990 }),
        select: () => beep({ freq: 440, duration: 0.1, type: 'square', gain: 0.06, slideTo: 660 }),
        advance: () => beep({ freq: 500, duration: 0.09, type: 'triangle', gain: 0.06, slideTo: 780 }),
        exit: () => beep({ freq: 420, duration: 0.12, type: 'square', gain: 0.06, slideTo: 220 }),
        achievement: () => beep({ freq: 740, duration: 0.16, type: 'triangle', gain: 0.06, slideTo: 1180 }),
    };
})();

// Sound mute toggle in the nav bar; purely a localStorage flag Sound reads.
(function () {
    const btn = document.getElementById('sound-toggle');
    if (!btn) return;

    function render() {
        const muted = Sound.isMuted();
        btn.setAttribute('aria-pressed', muted ? 'true' : 'false');
        btn.setAttribute('aria-label', muted ? 'Nyalakan suara' : 'Matikan suara');
    }

    btn.addEventListener('click', () => {
        Sound.setMuted(!Sound.isMuted());
        render();
    });

    render();
})();

// Arcade "Press Start" gate: blocks the page until the visitor presses
// START. Clicking anywhere else on the title screen makes the button grow,
// so it becomes impossible to miss.
(function () {
    const gate = document.getElementById('start-gate');
    const btn = document.getElementById('start-btn');
    const hint = document.getElementById('start-hint');
    if (!gate || !btn) return;

    document.body.style.overflow = 'hidden';

    const BASE_SIZE = 1.4;
    const STEP = 0.4;
    const MAX_SIZE = 4.8;
    let misses = 0;

    const hints = [
        'Tekan START untuk memulai petualangan',
        'Eh, bukan di situ, Player!',
        'START-nya makin gede biar nggak meleset lagi...',
        'Ayo, klik yang kuning menyala itu!',
        'Udah segede ini masih meleset? Semangat, dikit lagi!',
    ];

    function grow() {
        misses += 1;
        const size = Math.min(BASE_SIZE + misses * STEP, MAX_SIZE);
        btn.style.fontSize = `${size}rem`;
        if (hint) hint.textContent = hints[Math.min(misses, hints.length - 1)];
        Sound.blip();
    }

    function dismiss() {
        Sound.confirm();

        // Reveal character-select *before* the gate starts fading, so it's
        // already sitting behind the gate (z-index just below it) the
        // instant the fade begins -- otherwise the dashboard peeks through
        // for a frame or two while the gate is transparent but
        // character-select hasn't appeared yet.
        const select = document.getElementById('character-select');
        if (select) select.hidden = false;

        gate.classList.add('is-dismissed');
        // Body scroll stays locked -- the character-select screen picks up
        // right after this and unlocks it once a character is chosen.
        window.setTimeout(() => {
            gate.remove();
            if (!select) {
                document.body.style.overflow = '';
                window.dispatchEvent(new CustomEvent('game:start'));
            }
        }, 350);
    }

    btn.addEventListener('click', (e) => {
        e.stopPropagation();
        dismiss();
    });

    gate.addEventListener('click', (e) => {
        if (e.target.closest('#start-btn')) return;
        grow();
    });
})();

// Character select: second title-screen step after START. The chosen mascot
// becomes a small floating companion that follows the visitor around the
// page for the rest of the visit, with a click-for-a-quote speech bubble.
(function () {
    const select = document.getElementById('character-select');
    if (!select) return;

    const pet = document.getElementById('pet-companion');
    const petBubble = document.getElementById('pet-bubble');
    const petAvatar = document.getElementById('pet-avatar');
    const STORAGE_KEY = 'portfolio_pet_choice';

    const characters = {
        knight: { quotes: ['Siap bertarung!', 'Zero bug adalah misi utama.', 'Untuk kejayaan proyek ini!'] },
        princess: { quotes: ['Untuk kejayaan kerajaan kode ini!', 'Anggun di UI, tegas di logic.', 'Setiap baris adalah mahkota kemenangan.'] },
        dragon: { quotes: ['Grrr... lapar commit baru!', 'Deploy atau mati!', 'Aku jaga server ini.'] },
    };

    let currentChoice = null;
    let bubbleTimer = null;
    let bubbleHideTimer = null;
    let wandering = false;

    try {
        const saved = localStorage.getItem(STORAGE_KEY);
        if (saved && characters[saved]) {
            currentChoice = saved;
            const card = select.querySelector(`[data-character="${saved}"]`);
            if (card) card.classList.add('is-picked');
        }
    } catch (e) {
        // ignore unavailable storage
    }

    function sayRandomQuote() {
        const quotes = currentChoice && characters[currentChoice] ? characters[currentChoice].quotes : [];
        if (!quotes.length || !petBubble) return;
        petBubble.textContent = quotes[Math.floor(Math.random() * quotes.length)];
        petBubble.classList.add('is-active');
        window.clearTimeout(bubbleHideTimer);
        bubbleHideTimer = window.setTimeout(() => petBubble.classList.remove('is-active'), 2600);
    }

    // The companion pipes up on its own every so often, on top of reacting
    // to a click -- keeps it feeling alive instead of a static sticker.
    function scheduleAutoQuote() {
        window.clearTimeout(bubbleTimer);
        const delay = 6000 + Math.random() * 7000;
        bubbleTimer = window.setTimeout(() => {
            sayRandomQuote();
            scheduleAutoQuote();
        }, delay);
    }

    // Wandering: pick a random spot in the viewport (clear of the header and
    // the HUD corners) and walk there, flipping to face the direction of
    // travel, then pause and pick a new spot -- a little screen pet.
    function startWandering() {
        if (!pet || wandering) return;
        wandering = true;

        const rect = pet.getBoundingClientRect();
        pet.style.right = 'auto';
        pet.style.bottom = 'auto';
        pet.style.left = `${rect.left}px`;
        pet.style.top = `${rect.top}px`;

        const size = Math.max(rect.width, 54);

        function pickTarget() {
            const padding = 16;
            const topBound = 84;
            const bottomBound = Math.max(window.innerHeight - size - padding, topBound);
            const leftBound = padding;
            const rightBound = Math.max(window.innerWidth - size - padding, leftBound);
            return {
                x: leftBound + Math.random() * (rightBound - leftBound),
                y: topBound + Math.random() * (bottomBound - topBound),
            };
        }

        function step() {
            const current = pet.getBoundingClientRect();
            const target = pickTarget();
            pet.classList.toggle('is-facing-left', target.x < current.left);

            const distance = Math.hypot(target.x - current.left, target.y - current.top);
            const duration = Math.min(Math.max(distance / 80, 1), 3.5);
            pet.style.transitionDuration = `${duration}s`;
            pet.style.left = `${target.x}px`;
            pet.style.top = `${target.y}px`;

            const pause = 1500 + Math.random() * 2500;
            window.setTimeout(step, duration * 1000 + pause);
        }

        window.setTimeout(step, 1200);
    }

    function choose(id) {
        if (!characters[id]) return;
        currentChoice = id;
        Sound.select();

        try {
            localStorage.setItem(STORAGE_KEY, id);
        } catch (e) {
            // ignore unavailable storage
        }

        select.hidden = true;

        if (pet) {
            pet.hidden = false;
            pet.querySelectorAll('.pet-icon').forEach((el) => {
                el.classList.toggle('is-active', el.dataset.character === id);
            });
            startWandering();
            scheduleAutoQuote();
        }

        // Next title-screen step: let the visitor choose Adventure (guided
        // quest storyline) vs Creative (classic free scroll) before the page
        // unlocks. If that screen isn't in the DOM for some reason, fall
        // back to the old behaviour and start the page straight away.
        const modeSelect = document.getElementById('mode-select');
        if (modeSelect) {
            modeSelect.hidden = false;
        } else {
            document.body.style.overflow = '';
            window.dispatchEvent(new CustomEvent('game:start'));
        }
    }

    select.querySelectorAll('.character-card').forEach((card) => {
        card.addEventListener('click', () => choose(card.dataset.character));
    });

    if (petAvatar) {
        petAvatar.addEventListener('click', (e) => {
            e.stopPropagation();
            sayRandomQuote();
            scheduleAutoQuote();
        });
    }
})();

// Mode select: third title-screen step after character pick. Adventure Mode
// walks the visitor through each section as a guided quest line (with an
// ambient weather effect per stop); Creative Mode is the classic free-scroll
// experience this site always had.
(function () {
    const modeSelect = document.getElementById('mode-select');
    if (!modeSelect) return;

    function pick(mode) {
        Sound.confirm();
        modeSelect.hidden = true;
        document.body.style.overflow = '';
        window.dispatchEvent(new CustomEvent('game:start'));
        if (mode === 'adventure') window.dispatchEvent(new CustomEvent('adventure:start'));
    }

    modeSelect.querySelectorAll('.mode-card').forEach((card) => {
        card.addEventListener('click', () => pick(card.dataset.mode));
    });
})();

// Adventure Mode: guided quest line through the page's sections, with a
// dialogue-style panel and an ambient weather effect (visual + audio) per
// stop. Listens for the same section ids the XP HUD already tracks, so
// manual scrolling -- not just the "next quest" button -- keeps it in sync.
(function () {
    const panel = document.getElementById('quest-guide');
    if (!panel) return;

    const canvas = document.getElementById('weather-canvas');
    const ctx = canvas ? canvas.getContext('2d') : null;

    const steps = [
        { id: 'top', title: 'Gerbang Portofolio', text: 'Perjalanan dimulai di sini, Player. Tarik napas -- dunia ini siap dijelajahi.', weather: 'sunny' },
        { id: 'about', title: 'Kenali Sang Karakter', text: 'Sebelum lanjut, kenalan dulu sama pemilik dunia ini lewat lore-nya.', weather: 'autumn' },
        { id: 'stats', title: 'Skill Tree', text: 'Lihat stat yang sudah di-level-up lewat bertahun-tahun latihan.', weather: 'sunny' },
        { id: 'experience', title: 'Medan Pertempuran', text: 'Mission Log: quest-quest nyata yang pernah ditaklukkan di dunia kerja.', weather: 'rain' },
        { id: 'achievements', title: 'Ruang Trofi', text: 'Bukti dari setiap quest yang berhasil diselesaikan sampai tuntas.', weather: 'snow' },
        { id: 'education', title: 'Balai Guild', text: 'Tempat sang karakter dilatih, disertifikasi, dan naik rank.', weather: 'autumn' },
        { id: 'contact', title: 'Portal Komunikasi', text: 'Mau merekrut karakter ini ke party-mu? Kirim pesan lewat portal ini.', weather: 'snow' },
        { id: 'comments', title: 'Balai Warga', text: 'Quest terakhir: tinggalkan jejakmu di guestbook sebelum lanjut ke petualangan lain.', weather: 'rain' },
    ];

    // The quest-giver NPC is the portfolio owner in first person -- a
    // separate persona from the wandering pet companion, so the two don't
    // read as the same character shown twice. Name/avatar come from the
    // hero data server-side; only the per-stop lines live here.
    const npcLines = [
        'Halo, Player! Aku yang punya dunia ini -- makasih udah mampir. Yuk, kutemani jelajahi perjalananku dari awal.',
        'Ini ceritaku -- dari lulus kuliah dengan IPK nyaris sempurna sampai jatuh cinta sama dunia development.',
        'Ini skill yang kuasah bertahun-tahun -- dari Laravel, Python, sampai Machine Learning.',
        'Ini rekam jejak kerjaku -- dari staff IT programmer sampai R&D. Semua nyata, bukan cuma teori.',
        'Proyek-proyek yang paling kubanggakan ada di sini. Masing-masing punya cerita perjuangannya sendiri.',
        'Latar belakang pendidikan dan sertifikasi yang membentukku jadi developer seperti sekarang.',
        'Kalau kamu tertarik kolaborasi atau sekadar say hi, ini caranya menghubungiku.',
        'Sebelum lanjut ke petualangan lain, boleh tinggalkan jejak di buku tamu ini? Aku bakal baca satu-satu.',
    ];

    const stepEl = panel.querySelector('.js-quest-step');
    const titleEl = panel.querySelector('.js-quest-title');
    const textEl = panel.querySelector('.js-quest-text');
    const npcLineEl = panel.querySelector('.js-npc-line');
    const portraitEl = panel.querySelector('.quest-guide-portrait');
    const nextBtn = document.getElementById('quest-guide-next');
    const exitBtn = document.getElementById('quest-guide-exit');

    let active = false;
    let current = 0;

    // The wandering pet (knight/princess/dragon) is a separate persona from
    // the quest-giver NPC above -- this only reads its choice, for the
    // checkpoint (which character-select card to replay) and the ending
    // screen's "companion" stat.
    const PET_KEY = 'portfolio_pet_choice';
    const petDisplayNames = { knight: 'KNIGHT', princess: 'PRINCESS', dragon: 'DRAGON' };

    function currentPetChoice() {
        try {
            const saved = localStorage.getItem(PET_KEY);
            return petDisplayNames[saved] ? saved : null;
        } catch (e) {
            return null;
        }
    }

    // --- Checkpoint: remember progress so a reload mid-adventure can pick
    // back up instead of forcing a restart from the title screen. ----------
    const PROGRESS_KEY = 'portfolio_adventure_progress';

    function saveProgress() {
        try {
            localStorage.setItem(PROGRESS_KEY, JSON.stringify({ character: currentPetChoice() || 'knight', step: current }));
        } catch (e) {
            // ignore unavailable storage
        }
    }

    function clearProgress() {
        try {
            localStorage.removeItem(PROGRESS_KEY);
        } catch (e) {
            // ignore unavailable storage
        }
    }

    // --- Achievement toasts at a couple of story beats ---------------------
    const achievementToast = document.getElementById('achievement-toast');
    const achievementSubEl = achievementToast ? achievementToast.querySelector('.js-achievement-sub') : null;
    const achievementMilestones = { 0: 'Petualangan Dimulai!', 4: 'Mencapai Ruang Trofi!' };
    const achievedMilestones = new Set();
    let achievementTimer = null;

    function showAchievement(text) {
        if (!achievementToast) return;
        Sound.achievement();
        if (achievementSubEl) achievementSubEl.textContent = text;
        achievementToast.classList.add('is-active');
        window.clearTimeout(achievementTimer);
        achievementTimer = window.setTimeout(() => achievementToast.classList.remove('is-active'), 3200);
    }

    // --- Quest journal: on-demand overview of all stops with their status -
    const journalBtn = document.getElementById('quest-guide-journal-btn');
    const journalPanel = document.getElementById('quest-journal');
    const journalList = journalPanel ? journalPanel.querySelector('.js-journal-list') : null;
    const journalClose = document.getElementById('quest-journal-close');

    function closeJournal() {
        if (journalPanel) journalPanel.hidden = true;
    }

    function openJournal() {
        if (!journalPanel || !journalList) return;
        journalList.innerHTML = '';
        steps.forEach((step, index) => {
            const done = index < current;
            const isCurrent = index === current;
            const li = document.createElement('li');
            li.className = `quest-journal-item${done ? ' is-done' : ''}${isCurrent ? ' is-current' : ''}`;
            li.innerHTML = `
                <span class="box">${done ? '✓' : index + 1}</span>
                <span class="label font-body">${step.title}</span>
            `;
            li.addEventListener('click', () => {
                Sound.blip();
                closeJournal();
                const target = document.getElementById(step.id);
                if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
            journalList.appendChild(li);
        });
        journalPanel.hidden = false;
    }

    if (journalBtn) journalBtn.addEventListener('click', openJournal);
    if (journalClose) journalClose.addEventListener('click', closeJournal);
    if (journalPanel) {
        journalPanel.addEventListener('click', (e) => {
            if (e.target === journalPanel) closeJournal();
        });
    }

    // --- Weather engine (rain / snow / autumn leaves / sunny motes) -------
    const reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    let particles = [];
    let currentWeather = null;
    let rafId = null;
    let width = 0;
    let height = 0;

    function resize() {
        if (!canvas) return;
        width = canvas.width = window.innerWidth;
        height = canvas.height = window.innerHeight;
    }

    function spawn(type, initial) {
        const x = Math.random() * width;
        const y = initial ? Math.random() * height : -20;
        if (type === 'rain') {
            return { x, y, len: 12 + Math.random() * 14, speed: 7 + Math.random() * 5, drift: -1.5 };
        }
        if (type === 'snow') {
            return { x, y, r: 1.5 + Math.random() * 2.5, speed: 0.6 + Math.random() * 1.2, sway: Math.random() * Math.PI * 2, swaySpeed: 0.01 + Math.random() * 0.02 };
        }
        if (type === 'autumn') {
            return {
                x, y, size: 5 + Math.random() * 5, speed: 0.8 + Math.random() * 1,
                sway: Math.random() * Math.PI * 2, swaySpeed: 0.015 + Math.random() * 0.02,
                rotation: Math.random() * Math.PI * 2, rotSpeed: (Math.random() - 0.5) * 0.05,
                color: ['#ffec27', '#ff9d3d', '#ff004d'][Math.floor(Math.random() * 3)],
            };
        }
        return { x, y: initial ? Math.random() * height : height + 10, r: 1 + Math.random() * 2, speed: 0.2 + Math.random() * 0.3, twinkle: Math.random() * Math.PI * 2 };
    }

    function makeParticles(type) {
        resize();
        const count = { rain: 90, snow: 70, autumn: 45, sunny: 26 }[type] || 0;
        return Array.from({ length: count }, () => spawn(type, true));
    }

    function draw() {
        if (!ctx) return;
        ctx.clearRect(0, 0, width, height);

        if (currentWeather === 'rain') {
            ctx.strokeStyle = 'rgba(158, 210, 255, 0.55)';
            ctx.lineWidth = 1.5;
            particles.forEach((p) => {
                ctx.beginPath();
                ctx.moveTo(p.x, p.y);
                ctx.lineTo(p.x + p.drift, p.y + p.len);
                ctx.stroke();
                p.y += p.speed;
                p.x += p.drift * 0.2;
                if (p.y > height) Object.assign(p, spawn('rain', false));
            });
        } else if (currentWeather === 'snow') {
            ctx.fillStyle = 'rgba(255, 255, 255, 0.85)';
            particles.forEach((p) => {
                p.sway += p.swaySpeed;
                p.x += Math.sin(p.sway) * 0.6;
                p.y += p.speed;
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                ctx.fill();
                if (p.y > height) Object.assign(p, spawn('snow', false));
            });
        } else if (currentWeather === 'autumn') {
            particles.forEach((p) => {
                p.sway += p.swaySpeed;
                p.rotation += p.rotSpeed;
                p.x += Math.sin(p.sway) * 0.8;
                p.y += p.speed;
                ctx.save();
                ctx.translate(p.x, p.y);
                ctx.rotate(p.rotation);
                ctx.fillStyle = p.color;
                ctx.fillRect(-p.size / 2, -p.size / 2, p.size, p.size * 0.7);
                ctx.restore();
                if (p.y > height) Object.assign(p, spawn('autumn', false));
            });
        } else if (currentWeather === 'sunny') {
            particles.forEach((p) => {
                p.twinkle += 0.05;
                p.y -= p.speed;
                const alpha = Math.max(0.15, 0.4 + Math.sin(p.twinkle) * 0.4);
                ctx.fillStyle = `rgba(255, 236, 39, ${alpha})`;
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                ctx.fill();
                if (p.y < -10) Object.assign(p, spawn('sunny', false));
            });
        }

        rafId = window.requestAnimationFrame(draw);
    }

    function setWeather(type) {
        if (type === currentWeather) return;
        currentWeather = type;

        Sound.playAmbient(type);

        if (!canvas || !ctx || reduceMotion) return;

        if (!type) {
            canvas.classList.remove('is-active');
            if (rafId) window.cancelAnimationFrame(rafId);
            rafId = null;
            particles = [];
            return;
        }

        particles = makeParticles(type);
        canvas.classList.add('is-active');
        if (!rafId) rafId = window.requestAnimationFrame(draw);
    }

    window.addEventListener('resize', resize);
    resize();

    // --- Quest line ---------------------------------------------------
    // The panel docks over the bottom of the viewport, so the page reserves
    // matching space (body padding-bottom) equal to its real rendered
    // height -- otherwise it would sit on top of whatever section the
    // visitor scrolled to instead of living in its own strip.
    function updateBodyOffset() {
        if (!panel || panel.hidden) {
            document.documentElement.style.removeProperty('--quest-guide-space');
            return;
        }
        const rect = panel.getBoundingClientRect();
        const space = Math.max(window.innerHeight - rect.top + 24, 0);
        document.documentElement.style.setProperty('--quest-guide-space', `${space}px`);
    }

    if ('ResizeObserver' in window) {
        new ResizeObserver(updateBodyOffset).observe(panel);
    }
    window.addEventListener('resize', updateBodyOffset);

    function renderStep(index) {
        const step = steps[index];
        if (!step) return;
        current = index;
        if (stepEl) stepEl.textContent = `QUEST ${index + 1}/${steps.length}`;
        if (titleEl) titleEl.textContent = step.title;
        if (textEl) textEl.textContent = step.text;
        if (npcLineEl) npcLineEl.textContent = `“${npcLines[index]}”`;
        if (nextBtn) {
            const isLast = index === steps.length - 1;
            nextBtn.textContent = isLast ? 'SELESAIKAN PETUALANGAN ★' : 'LANJUTKAN QUEST ▸';
            nextBtn.disabled = false;
        }
        if (portraitEl) {
            portraitEl.classList.remove('is-talking');
            void portraitEl.offsetWidth;
            portraitEl.classList.add('is-talking');
        }
        setWeather(step.weather);
        updateBodyOffset();
        saveProgress();

        if (achievementMilestones[index] && !achievedMilestones.has(index)) {
            achievedMilestones.add(index);
            showAchievement(achievementMilestones[index]);
        }
    }

    // "Lanjutkan Quest" doesn't just smooth-scroll -- it cuts to black with a
    // title card, jumps the page to the next section while hidden, then
    // clears, like a scene transition between levels instead of a scroll.
    const transitionOverlay = document.getElementById('quest-transition');
    const transitionStepEl = transitionOverlay ? transitionOverlay.querySelector('.js-transition-step') : null;
    const transitionTitleEl = transitionOverlay ? transitionOverlay.querySelector('.js-transition-title') : null;
    let transitioning = false;

    // An instant jump across several sections (replay-to-top, checkpoint
    // resume, the mid-transition cut) can make more than one section cross
    // the IntersectionObserver's threshold in the same reflow -- the browser
    // then reports all of them in one batch, in no particular order, which
    // would let a stale entry stomp the renderStep() call this function
    // already made. Muting the observer briefly makes the explicit call the
    // only source of truth for that jump.
    let suppressObserver = false;

    function jumpTo(index, behavior) {
        suppressObserver = true;
        const target = document.getElementById(steps[index].id);
        if (target) target.scrollIntoView({ behavior, block: 'start' });
        renderStep(index);
        window.setTimeout(() => {
            suppressObserver = false;
        }, 400);
    }

    function goNext() {
        if (transitioning) return;
        const next = Math.min(current + 1, steps.length - 1);
        if (next === current) return;
        transitioning = true;
        Sound.advance();
        if (nextBtn) nextBtn.disabled = true;

        const step = steps[next];
        if (transitionStepEl) transitionStepEl.textContent = `QUEST ${next + 1}/${steps.length}`;
        if (transitionTitleEl) transitionTitleEl.textContent = step.title;

        if (!transitionOverlay) {
            jumpTo(next, 'smooth');
            transitioning = false;
            return;
        }

        transitionOverlay.classList.add('is-active');

        window.setTimeout(() => {
            jumpTo(next, 'instant');

            window.setTimeout(() => {
                transitionOverlay.classList.remove('is-active');
                transitioning = false;
            }, 650);
        }, 260);
    }

    function exitAdventure() {
        Sound.exit();
        active = false;
        transitioning = false;
        panel.hidden = true;
        if (transitionOverlay) transitionOverlay.classList.remove('is-active');
        setWeather(null);
        updateBodyOffset();
        clearProgress();
    }

    // --- Ending screen: full victory recap once every quest is done --------
    const endingOverlay = document.getElementById('adventure-ending');
    const endingQuestsEl = endingOverlay ? endingOverlay.querySelector('.js-ending-quests') : null;
    const endingXpEl = endingOverlay ? endingOverlay.querySelector('.js-ending-xp') : null;
    const endingCompanionEl = endingOverlay ? endingOverlay.querySelector('.js-ending-companion') : null;
    const endingReplayBtn = document.getElementById('adventure-ending-replay');
    const endingCreativeBtn = document.getElementById('adventure-ending-creative');

    function readTotalXp() {
        try {
            const saved = JSON.parse(localStorage.getItem('portfolio_xp_state_v1') || 'null');
            if (saved && typeof saved.xp === 'number') return saved.xp;
        } catch (e) {
            // ignore unavailable storage
        }
        return 0;
    }

    function finishAdventure() {
        Sound.victory();
        clearProgress();
        if (endingQuestsEl) endingQuestsEl.textContent = `${steps.length}/${steps.length}`;
        if (endingXpEl) endingXpEl.textContent = `${readTotalXp()} XP`;
        if (endingCompanionEl) endingCompanionEl.textContent = petDisplayNames[currentPetChoice()] || '-';
        if (endingOverlay) endingOverlay.hidden = false;
    }

    if (endingReplayBtn) {
        endingReplayBtn.addEventListener('click', () => {
            Sound.confirm();
            if (endingOverlay) endingOverlay.hidden = true;
            jumpTo(0, 'instant');
        });
    }

    if (endingCreativeBtn) {
        endingCreativeBtn.addEventListener('click', () => {
            Sound.confirm();
            if (endingOverlay) endingOverlay.hidden = true;
            exitAdventure();
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            if (current === steps.length - 1) finishAdventure();
            else goNext();
        });
    }

    // --- Keyboard controls: arrow-right/Enter to advance, Esc to back out --
    window.addEventListener('keydown', (e) => {
        if (!active) return;
        const tag = document.activeElement ? document.activeElement.tagName : '';
        if (tag === 'INPUT' || tag === 'TEXTAREA') return;

        if (e.key === 'ArrowRight' || e.key === 'Enter') {
            e.preventDefault();
            if (transitioning || (endingOverlay && !endingOverlay.hidden)) return;
            if (current === steps.length - 1) finishAdventure();
            else goNext();
        } else if (e.key === 'Escape') {
            e.preventDefault();
            if (journalPanel && !journalPanel.hidden) closeJournal();
            else if (!endingOverlay || endingOverlay.hidden) exitAdventure();
        }
    });
    if (exitBtn) exitBtn.addEventListener('click', exitAdventure);

    window.addEventListener('adventure:start', () => {
        active = true;
        panel.hidden = false;

        // Checkpoint resume: the title-screen replay (see the bottom of this
        // file) stashes the saved step here right before it clicks the
        // "adventure" mode card, so this listener runs synchronously inside
        // that click and can pick it straight up.
        const resumeStep = window.__adventureResumeStep;
        delete window.__adventureResumeStep;
        const startIndex = typeof resumeStep === 'number' && resumeStep >= 0 && resumeStep < steps.length ? resumeStep : 0;

        if (startIndex > 0) jumpTo(startIndex, 'instant');
        else renderStep(0);
    });

    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver(
            (entries) => {
                if (!active || suppressObserver) return;
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) return;
                    const index = steps.findIndex((step) => step.id === entry.target.id);
                    if (index !== -1) renderStep(index);
                });
            },
            { threshold: 0, rootMargin: '0px 0px -55% 0px' }
        );
        steps.forEach((step) => {
            const el = document.getElementById(step.id);
            if (el) observer.observe(el);
        });
    }
})();

// Checkpoint resume: if a saved Adventure Mode session exists from a
// previous visit, auto-replay the title-screen flow (gate -> character ->
// mode) instead of leaving the visitor to start over from Quest 1. Runs
// last so every click handler above is already wired up.
(function () {
    let saved = null;
    try {
        saved = JSON.parse(localStorage.getItem('portfolio_adventure_progress') || 'null');
    } catch (e) {
        saved = null;
    }
    if (!saved || !['knight', 'princess', 'dragon'].includes(saved.character) || typeof saved.step !== 'number') {
        return;
    }

    const startBtn = document.getElementById('start-btn');
    const card = document.querySelector(`.character-card[data-character="${saved.character}"]`);
    const adventureCard = document.querySelector('.mode-card[data-mode="adventure"]');
    if (!startBtn || !card || !adventureCard) return;

    window.__adventureResumeStep = saved.step;
    startBtn.click();
    card.click();
    adventureCard.click();
})();

// Guestbook comments: posted under the visitor's chosen mascot via fetch, so
// the list updates without a full page reload (which would also reset the
// pet's wander position and the XP HUD's in-progress animations).
(function () {
    const form = document.getElementById('comment-form');
    const list = document.getElementById('comment-list');
    if (!form || !list) return;

    const errorEl = document.getElementById('comment-error');
    const formAvatar = document.getElementById('comment-form-avatar');
    const PET_KEY = 'portfolio_pet_choice';
    const CHARACTERS = ['knight', 'princess', 'dragon'];

    function currentCharacter() {
        try {
            const saved = localStorage.getItem(PET_KEY);
            if (saved && CHARACTERS.includes(saved)) return saved;
        } catch (e) {
            // ignore unavailable storage
        }
        return 'knight';
    }

    function cloneIcon(character) {
        const tpl = document.getElementById(`tpl-comment-icon-${character}`);
        return tpl ? tpl.content.cloneNode(true) : null;
    }

    function renderFormAvatar() {
        if (!formAvatar) return;
        formAvatar.innerHTML = '';
        const icon = cloneIcon(currentCharacter());
        if (icon) formAvatar.appendChild(icon);
    }

    function buildCommentItem({ name, message, character }) {
        const li = document.createElement('li');
        li.className = 'comment-item comment-item-new';

        const avatar = document.createElement('span');
        avatar.className = 'comment-avatar';
        const icon = cloneIcon(character);
        if (icon) avatar.appendChild(icon);

        const nameEl = document.createElement('span');
        nameEl.className = 'comment-name font-display';
        nameEl.textContent = name;

        const timeEl = document.createElement('span');
        timeEl.className = 'comment-time';
        timeEl.textContent = 'Baru saja';

        const meta = document.createElement('div');
        meta.className = 'comment-meta';
        meta.appendChild(nameEl);
        meta.appendChild(timeEl);

        const messageEl = document.createElement('p');
        messageEl.className = 'comment-message font-body';
        messageEl.textContent = message;

        const body = document.createElement('div');
        body.className = 'comment-body';
        body.appendChild(meta);
        body.appendChild(messageEl);

        li.appendChild(avatar);
        li.appendChild(body);
        return li;
    }

    renderFormAvatar();
    window.addEventListener('game:start', renderFormAvatar);

    form.addEventListener('submit', (e) => {
        e.preventDefault();

        if (errorEl) {
            errorEl.classList.add('hidden');
            errorEl.textContent = '';
        }

        const nameField = form.querySelector('#comment-name');
        const messageField = form.querySelector('#comment-message');
        const name = nameField.value.trim();
        const message = messageField.value.trim();
        if (!name || !message) return;

        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) submitBtn.disabled = true;

        window.axios
            .post('/comments', { name, message, character: currentCharacter() })
            .then((res) => {
                const empty = document.getElementById('comment-empty');
                if (empty) empty.remove();

                list.insertBefore(buildCommentItem(res.data.comment), list.firstChild);
                messageField.value = '';
                window.dispatchEvent(new CustomEvent('portfolio:commented'));
            })
            .catch((err) => {
                if (!errorEl) return;
                const message = err.response?.data?.message || 'Gagal mengirim komentar. Coba lagi.';
                errorEl.textContent = message;
                errorEl.classList.remove('hidden');
            })
            .finally(() => {
                if (submitBtn) submitBtn.disabled = false;
            });
    });
})();

// Visitor XP HUD: gamifies scrolling through the page and clicking outbound
// links; state persists per-browser via localStorage so returning visitors
// keep their level. Starts tracking once the "Press Start" gate is cleared.
(function () {
    const hud = document.getElementById('xp-hud');
    if (!hud) return;

    const MAX_LEVEL = 5;
    const STORAGE_KEY = 'portfolio_xp_state_v1';

    const sectionTasks = [
        { key: 'top', amount: 10, label: 'Mulai Eksplorasi' },
        { key: 'about', amount: 20, label: 'About Me' },
        { key: 'stats', amount: 20, label: 'Skill Meter' },
        { key: 'experience', amount: 20, label: 'Mission Log' },
        { key: 'achievements', amount: 20, label: 'Achievements' },
        { key: 'education', amount: 20, label: 'Education' },
        { key: 'contact', amount: 20, label: 'Contact' },
        { key: 'comments', amount: 20, label: 'Guestbook' },
        { key: 'wrote-comment', amount: 20, label: 'Tulis Komentar' },
    ];
    const sectionXp = Object.fromEntries(sectionTasks.map((task) => [task.key, task]));
    let linkTasks = [];

    let state = { xp: 0, visited: [] };
    try {
        const saved = JSON.parse(localStorage.getItem(STORAGE_KEY) || 'null');
        if (saved && typeof saved.xp === 'number' && Array.isArray(saved.visited)) {
            state = saved;
        }
    } catch (e) {
        // ignore malformed/unavailable storage
    }

    const levelEl = hud.querySelector('.js-xp-level');
    const countEl = hud.querySelector('.js-xp-count');
    const fillEl = hud.querySelector('.js-xp-fill');
    const popupEl = document.getElementById('xp-popup');
    const toastEl = document.getElementById('level-up-toast');
    const toastSub = toastEl ? toastEl.querySelector('.sub') : null;
    let toastTimer = null;

    const panel = document.getElementById('xp-progress-panel');
    const panelList = panel ? panel.querySelector('.js-progress-list') : null;
    const panelTitle = panel ? panel.querySelector('.js-progress-title') : null;
    const panelRemaining = panel ? panel.querySelector('.js-progress-remaining') : null;
    const panelClose = document.getElementById('xp-progress-close');

    // Levels are spread evenly across the total XP available from every
    // task (all sections + all outbound links), so reaching MAX LEVEL lines
    // up exactly with checking off every mission -- not some arbitrary flat
    // XP-per-level count that could strand the visitor mid-bar forever.
    function levelInfo(xp) {
        const totalXp = [...sectionTasks, ...linkTasks].reduce((sum, task) => sum + task.amount, 0);
        const steps = MAX_LEVEL - 1;
        const thresholds = [];
        for (let i = 1; i <= steps; i += 1) {
            thresholds.push(Math.round((totalXp * i) / steps));
        }

        const passed = thresholds.filter((t) => xp >= t).length;
        const level = Math.min(1 + passed, MAX_LEVEL);
        const isMax = level >= MAX_LEVEL;
        const prev = passed === 0 ? 0 : thresholds[passed - 1];
        const next = isMax ? totalXp : thresholds[passed];
        const span = Math.max(next - prev, 1);
        const into = Math.min(Math.max(xp - prev, 0), span);

        return {
            level,
            isMax,
            into,
            span,
            percent: isMax ? 100 : (into / span) * 100,
            remaining: isMax ? 0 : next - xp,
            totalXp,
        };
    }

    function labelForHref(href) {
        if (href.includes('linkedin.com')) return 'Kunjungi LinkedIn';
        if (href.includes('github.com')) return 'Kunjungi GitHub';
        if (href.includes('instagram.com')) return 'Kunjungi Instagram';
        if (href.startsWith('mailto:')) return 'Kirim Email';
        return 'Buka Link';
    }

    function renderPanel(info) {
        if (!panelList) return;
        if (panelTitle) {
            panelTitle.textContent = info.isMax ? 'SEMUA MISI SELESAI!' : `MENUJU LVL ${info.level + 1}`;
        }
        if (panelRemaining) {
            panelRemaining.textContent = info.isMax
                ? 'MAX LEVEL tercapai \u{1F389}'
                : `Butuh ${info.remaining} XP lagi untuk naik level`;
        }

        panelList.innerHTML = '';
        [...sectionTasks, ...linkTasks].forEach((task) => {
            const done = state.visited.includes(task.key);
            const li = document.createElement('li');
            li.className = `xp-progress-item${done ? ' is-done' : ''}`;
            li.innerHTML = `
                <span class="box">${done ? '✓' : ''}</span>
                <span class="label font-body">${task.label}</span>
                <span class="amount">+${task.amount}</span>
            `;
            if (!done) {
                li.addEventListener('click', (e) => {
                    e.stopPropagation();
                    let target;
                    if (task.key.startsWith('link:')) {
                        target = document.querySelector('footer');
                    } else if (task.key === 'wrote-comment') {
                        target = document.getElementById('comments');
                    } else {
                        target = document.getElementById(task.key);
                    }
                    if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    closePanel();
                });
            }
            panelList.appendChild(li);
        });
    }

    function render() {
        const info = levelInfo(state.xp);
        if (levelEl) levelEl.textContent = info.isMax ? 'LVL MAX' : `LVL ${info.level}`;
        if (countEl) {
            countEl.textContent = info.isMax
                ? `${info.totalXp}/${info.totalXp} XP`
                : `${info.into}/${info.span} XP`;
        }
        if (fillEl) fillEl.style.width = `${info.percent}%`;
        renderPanel(info);
    }

    function persist() {
        try {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(state));
        } catch (e) {
            // ignore unavailable storage
        }
    }

    function showPopup(text) {
        if (!popupEl) return;
        popupEl.textContent = text;
        popupEl.classList.remove('is-active');
        void popupEl.offsetWidth;
        popupEl.classList.add('is-active');
    }

    function showLevelUp(level, isMax) {
        if (!toastEl) return;
        if (toastSub) toastSub.textContent = isMax ? 'MAX LEVEL REACHED! \u{1F389}' : `You reached LVL ${level}`;
        toastEl.classList.add('is-active');
        window.clearTimeout(toastTimer);
        toastTimer = window.setTimeout(() => toastEl.classList.remove('is-active'), 2600);
    }

    function grantXp(key, amount, label) {
        if (state.visited.includes(key)) return;
        state.visited.push(key);

        const prevLevel = levelInfo(state.xp).level;
        state.xp += amount;
        const next = levelInfo(state.xp);

        persist();
        render();
        showPopup(`+${amount} XP — ${label}`);

        if (next.level > prevLevel) {
            showLevelUp(next.level, next.isMax);
        }
    }

    function openPanel() {
        if (!panel) return;
        panel.hidden = false;
        hud.setAttribute('aria-expanded', 'true');
    }

    function closePanel() {
        if (!panel) return;
        panel.hidden = true;
        hud.setAttribute('aria-expanded', 'false');
    }

    function togglePanel() {
        if (!panel) return;
        if (panel.hidden) openPanel();
        else closePanel();
    }

    hud.addEventListener('click', togglePanel);
    hud.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            togglePanel();
        }
    });
    if (panelClose) {
        panelClose.addEventListener('click', (e) => {
            e.stopPropagation();
            closePanel();
        });
    }
    document.addEventListener('click', (e) => {
        if (!panel || panel.hidden) return;
        if (panel.contains(e.target) || hud.contains(e.target)) return;
        closePanel();
    });

    function init() {
        document.querySelectorAll('a[target="_blank"], a[href^="mailto:"]').forEach((link) => {
            const key = `link:${link.href}`;
            if (!linkTasks.some((task) => task.key === key)) {
                linkTasks.push({ key, amount: 10, label: labelForHref(link.href) });
            }
            link.addEventListener('click', () => grantXp(key, 10, labelForHref(link.href)));
        });

        render();
        grantXp('top', sectionXp.top.amount, sectionXp.top.label);

        if ('IntersectionObserver' in window) {
            const ids = Object.keys(sectionXp).filter((id) => id !== 'top');
            // threshold 0 + a shrunk root (via rootMargin) fires as soon as a
            // section's edge crosses into the top ~40% of the viewport --
            // unlike an area-based threshold, this works correctly even for
            // sections taller than the viewport (e.g. Mission Log's stacked
            // cards), which could otherwise never reach a % of area visible.
            const observer = new IntersectionObserver(
                (entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            const cfg = sectionXp[entry.target.id];
                            if (cfg) grantXp(entry.target.id, cfg.amount, cfg.label);
                        }
                    });
                },
                { threshold: 0, rootMargin: '0px 0px -60% 0px' }
            );
            ids.forEach((id) => {
                const el = document.getElementById(id);
                if (el) observer.observe(el);
            });
        }

        window.addEventListener(
            'portfolio:commented',
            () => grantXp('wrote-comment', sectionXp['wrote-comment'].amount, sectionXp['wrote-comment'].label),
            { once: true }
        );
    }

    render();
    window.addEventListener('game:start', init, { once: true });
})();

// Scroll progress bar (boss-bar style)
const progressBar = document.getElementById('scroll-progress');
function updateScrollProgress() {
    if (!progressBar) return;
    const scrollable = document.documentElement.scrollHeight - window.innerHeight;
    const progress = scrollable > 0 ? (window.scrollY / scrollable) * 100 : 0;
    progressBar.style.width = `${progress}%`;
}
window.addEventListener('scroll', updateScrollProgress, { passive: true });
updateScrollProgress();

// Mobile nav toggle
const navToggle = document.getElementById('nav-toggle');
const navMobile = document.getElementById('nav-mobile');
if (navToggle && navMobile) {
    navToggle.addEventListener('click', () => {
        navMobile.classList.toggle('hidden');
        navMobile.classList.toggle('flex');
    });
    navMobile.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => {
            navMobile.classList.add('hidden');
            navMobile.classList.remove('flex');
        });
    });
}

// Animate stat bars into view
const statFills = document.querySelectorAll('.js-stat-fill');
if (statFills.length && 'IntersectionObserver' in window) {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    el.style.width = `${el.dataset.value}%`;
                    observer.unobserve(el);
                }
            });
        },
        { threshold: 0.4 }
    );
    statFills.forEach((el) => observer.observe(el));
} else {
    statFills.forEach((el) => {
        el.style.width = `${el.dataset.value}%`;
    });
}
