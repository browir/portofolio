import './bootstrap';

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
    }

    function dismiss() {
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

        try {
            localStorage.setItem(STORAGE_KEY, id);
        } catch (e) {
            // ignore unavailable storage
        }

        select.hidden = true;
        document.body.style.overflow = '';

        if (pet) {
            pet.hidden = false;
            pet.querySelectorAll('.pet-icon').forEach((el) => {
                el.classList.toggle('is-active', el.dataset.character === id);
            });
            startWandering();
            scheduleAutoQuote();
        }

        window.dispatchEvent(new CustomEvent('game:start'));
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
