export function initMobileNav() {
    const toggle = document.querySelector('[data-mobile-nav-toggle]');
    const panel = document.querySelector('[data-mobile-nav-panel]');

    if (!toggle || !panel) return;

    toggle.addEventListener('click', () => {
        const isOpen = panel.classList.toggle('hidden') === false;
        toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        document.body.classList.toggle('overflow-hidden', isOpen);
    });

    document.querySelectorAll('[data-mobile-nav-panel] a').forEach((link) => {
        link.addEventListener('click', () => {
            panel.classList.add('hidden');
            toggle.setAttribute('aria-expanded', 'false');
            document.body.classList.remove('overflow-hidden');
        });
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !panel.classList.contains('hidden')) {
            panel.classList.add('hidden');
            toggle.setAttribute('aria-expanded', 'false');
            document.body.classList.remove('overflow-hidden');
        }
    });
}

export function initDropdowns() {
    document.querySelectorAll('[data-dropdown-toggle]').forEach((toggle) => {
        const menu = document.getElementById(toggle.getAttribute('aria-controls'));
        if (!menu) return;

        const close = () => {
            menu.classList.add('hidden');
            toggle.setAttribute('aria-expanded', 'false');
        };

        toggle.addEventListener('click', (event) => {
            event.stopPropagation();
            const isHidden = menu.classList.toggle('hidden');
            toggle.setAttribute('aria-expanded', isHidden ? 'false' : 'true');
        });

        document.addEventListener('click', (event) => {
            if (!menu.contains(event.target) && event.target !== toggle) close();
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') close();
        });
    });
}
