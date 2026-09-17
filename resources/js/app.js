import './bootstrap';

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
