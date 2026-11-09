import './bootstrap';

const countUpValues = () => {
    document.querySelectorAll('[data-count]').forEach((element) => {
        const target = Number(element.dataset.count || 0);
        const suffix = element.dataset.suffix || '';
        const duration = 1000;
        const start = performance.now();

        const animate = (time) => {
            const progress = Math.min((time - start) / duration, 1);
            const current = Math.round(target * progress);
            element.textContent = `${current}${suffix}`;

            if (progress < 1) {
                requestAnimationFrame(animate);
            } else {
                element.textContent = `${target}${suffix}`;
            }
        };

        requestAnimationFrame(animate);
    });
};

const revealElements = () => {
    document.querySelectorAll('.reveal, .stat-card, .panel-section, .glass-card').forEach((el, index) => {
        el.style.animationDelay = `${index * 80}ms`;
        el.classList.add('reveal');
    });
};

const initIcons = () => {
    if (window.lucide && typeof window.lucide.createIcons === 'function') {
        window.lucide.createIcons();
    }
};

document.addEventListener('DOMContentLoaded', () => {
    countUpValues();
    revealElements();
    initIcons();
});
