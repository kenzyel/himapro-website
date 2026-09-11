import 'bootstrap';
import AOS from 'aos';
import { CountUp } from 'countup.js';

/* =========================================================
   PRELOAD HANDLER
   ========================================================= */

document.addEventListener('DOMContentLoaded', () => {
    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            document.body.classList.remove('preload');
        });
    });
});


/* =========================================================
   INIT DI DOMContentLoaded
   ========================================================= */

document.addEventListener('DOMContentLoaded', () => {

    /* =======================================================
       AOS — Animasi scroll
       ======================================================= */

    AOS.init({
        duration: 600,
        easing: 'ease-out-cubic',
        once: true,
        offset: 40,
        delay: 0,
    });


    /* =======================================================
       COUNTUP — Animasi angka statistik
       ======================================================= */

    document.querySelectorAll('[data-countup]').forEach((el) => {

        const target = parseInt(el.dataset.countup, 10);

        if (Number.isNaN(target)) {
            return;
        }

        const counter = new CountUp(el, target, {
            duration: 1.6,
            separator: '.',
            useEasing: true,
        });

        if (!counter.error) {

            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        counter.start();
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.3 });

            observer.observe(el);
        }
    });


    /* =======================================================
       AUTO DISMISS ALERTS
       ======================================================= */

    document.querySelectorAll('.alert-dismissible').forEach((alert) => {

        setTimeout(() => {
            alert.style.transition = 'opacity .4s ease, transform .4s ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';

            setTimeout(() => alert.remove(), 400);
        }, 5000);
    });


    /* =======================================================
       RIPPLE EFFECT
       ======================================================= */

    document.querySelectorAll('.btn-himapro, .btn-warning').forEach((btn) => {

        btn.addEventListener('click', function (e) {

            const rect = this.getBoundingClientRect();
            const ripple = document.createElement('span');

            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            ripple.style.cssText = `
                position: absolute;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                border-radius: 50%;
                background: rgba(0, 0, 0, 0.15);
                pointer-events: none;
                transform: scale(0);
                animation: ripple-anim .6s ease-out;
            `;

            if (getComputedStyle(this).position === 'static') {
                this.style.position = 'relative';
            }

            this.style.overflow = 'hidden';
            this.appendChild(ripple);

            setTimeout(() => ripple.remove(), 600);
        });
    });

});


/* =========================================================
   SIDEBAR TOGGLE — Desktop collapse + Mobile overlay
   ========================================================= */

(function () {

    const STORAGE_KEY = 'himapro-sidebar-collapsed';

    function isDesktop() {
        return window.innerWidth >= 768;
    }

    function applySavedState() {

        if (!isDesktop()) {
            return;
        }

        const collapsed = localStorage.getItem(STORAGE_KEY) === '1';

        if (collapsed) {
            document.body.classList.add('sidebar-collapsed');
        }
    }

    /**
     * Buka sidebar (mobile).
     */
    window.openSidebar = function () {
        const sidebar = document.querySelector('.admin-sidebar');
        const overlay = document.getElementById('adminSidebarOverlay') ||
                        document.querySelector('.admin-sidebar-overlay');

        if (!sidebar) return;

        sidebar.classList.add('sidebar-open');

        if (overlay) {
            overlay.classList.add('show');
            overlay.style.display = 'block';
        }

        document.body.classList.add('sidebar-locked');
    };

    /**
     * Tutup sidebar (mobile).
     */
    window.closeSidebar = function () {
        const sidebar = document.querySelector('.admin-sidebar');
        const overlay = document.getElementById('adminSidebarOverlay') ||
                        document.querySelector('.admin-sidebar-overlay');

        if (sidebar) {
            sidebar.classList.remove('sidebar-open');
        }

        if (overlay) {
            overlay.classList.remove('show');
            overlay.style.display = 'none';
        }

        document.body.classList.remove('sidebar-locked');
    };

    /**
     * Toggle sidebar.
     */
    window.toggleSidebar = function () {

        const sidebar = document.querySelector('.admin-sidebar');

        if (!sidebar) return;

        if (isDesktop()) {

            document.body.classList.toggle('sidebar-collapsed');

            const isCollapsed = document.body.classList.contains('sidebar-collapsed');

            localStorage.setItem(STORAGE_KEY, isCollapsed ? '1' : '0');

        } else {

            if (sidebar.classList.contains('sidebar-open')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        }
    };

    /**
     * ESC untuk close sidebar (mobile).
     */
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !isDesktop()) {
            closeSidebar();
        }
    });

    /**
     * Klik menu sidebar → tutup otomatis (mobile).
     */
    document.addEventListener('click', function (e) {
        if (isDesktop()) return;

        const link = e.target.closest('.admin-nav-link');

        if (link && !link.classList.contains('active')) {
            setTimeout(closeSidebar, 150);
        }
    });

    /**
     * Reset saat resize.
     */
    let resizeTimer;

    window.addEventListener('resize', () => {

        clearTimeout(resizeTimer);

        resizeTimer = setTimeout(() => {

            if (isDesktop()) {
                closeSidebar();
                applySavedState();
            } else {
                document.body.classList.remove('sidebar-collapsed');
            }

        }, 150);
    });

    document.addEventListener('DOMContentLoaded', applySavedState);

})();


/* =========================================================
   FRONTEND PUBLIK — Navbar & interaksi
   ========================================================= */

(function () {

    function initFrontendNavbar() {

        const navbar = document.querySelector('.fe-navbar');
        const toggle = document.querySelector('.fe-nav-toggle');
        const menu = document.querySelector('.fe-nav-menu');
        const overlay = document.querySelector('.fe-nav-overlay');

        if (!navbar) return;

        function handleScroll() {
            if (window.scrollY > 30) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        }

        window.addEventListener('scroll', handleScroll, { passive: true });
        handleScroll();

        function closeMenu() {
            menu?.classList.remove('open');
            overlay?.classList.remove('show');
            document.body.style.overflow = '';
        }

        function openMenu() {
            menu?.classList.add('open');
            overlay?.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        toggle?.addEventListener('click', function (e) {
            e.stopPropagation();
            if (menu?.classList.contains('open')) {
                closeMenu();
            } else {
                openMenu();
            }
        });

        overlay?.addEventListener('click', closeMenu);

        menu?.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', closeMenu);
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth > 991.98) {
                closeMenu();
            }
        });

    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initFrontendNavbar);
    } else {
        initFrontendNavbar();
    }

})();


/* =========================================================
   FRONTEND — Particle Generator & Tilt Effect
   ========================================================= */

document.addEventListener('DOMContentLoaded', function () {

    // Particle
    const particleContainers = document.querySelectorAll('.fe-particles');

    particleContainers.forEach(function (container) {
        if (container.children.length > 0) return;

        for (let i = 0; i < 20; i++) {
            const particle = document.createElement('div');
            particle.className = 'fe-particle';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.animationDelay = Math.random() * 15 + 's';
            particle.style.animationDuration = (10 + Math.random() * 15) + 's';
            container.appendChild(particle);
        }
    });

    // Tilt
    const tiltCards = document.querySelectorAll('.fe-tilt');

    tiltCards.forEach(function (card) {
        card.addEventListener('mousemove', function (e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const centerX = rect.width / 2;
            const centerY = rect.height / 2;

            const rotateY = ((x - centerX) / centerX) * 3;
            const rotateX = ((centerY - y) / centerY) * 3;

            this.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-6px)`;
        });

        card.addEventListener('mouseleave', function () {
            this.style.transform = '';
        });
    });

});


/* =========================================================
   GLOBAL SEARCH ADMIN
   ========================================================= */

(function () {

    function initAdminSearch() {

        const wrapper = document.getElementById('adminSearch');

        if (!wrapper) return;

        const trigger = document.getElementById('adminSearchTrigger');
        const modal = document.getElementById('adminSearchModal');
        const input = document.getElementById('adminSearchInput');
        const results = document.getElementById('adminSearchResults');
        const searchUrl = wrapper.dataset.searchUrl;

        let debounceTimer = null;
        let activeIndex = -1;
        let currentItems = [];

        // ============================
        // OPEN / CLOSE
        // ============================

        window.openAdminSearch = function () {
            modal.classList.add('open');
            document.body.style.overflow = 'hidden';
            setTimeout(() => input.focus(), 100);
        };

        window.closeAdminSearch = function () {
            modal.classList.remove('open');
            document.body.style.overflow = '';
            input.value = '';
            activeIndex = -1;
            currentItems = [];
            resetResults();
        };

        function resetResults() {
            results.innerHTML = `
                <div class="admin-search-empty">
                    <i class="bi bi-lightbulb"></i>
                    <div>
                        <div style="font-weight: 700; margin-bottom: 4px;">Mulai mencari</div>
                        <div style="font-size: 12px; color: var(--muted);">
                            Ketik minimal 2 karakter untuk mulai mencari.
                        </div>
                    </div>
                </div>
            `;
        }

        trigger?.addEventListener('click', window.openAdminSearch);

        // ============================
        // KEYBOARD SHORTCUT (Ctrl/Cmd + K)
        // ============================

        document.addEventListener('keydown', function (e) {
            if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
                e.preventDefault();

                if (modal.classList.contains('open')) {
                    window.closeAdminSearch();
                } else {
                    window.openAdminSearch();
                }
            }

            if (e.key === 'Escape' && modal.classList.contains('open')) {
                window.closeAdminSearch();
            }
        });

        // ============================
        // INPUT HANDLER (debounce)
        // ============================

        input?.addEventListener('input', function () {
            const q = this.value.trim();

            clearTimeout(debounceTimer);

            if (q.length < 2) {
                resetResults();
                activeIndex = -1;
                currentItems = [];
                return;
            }

            results.innerHTML = '<div class="admin-search-loading">Mencari...</div>';

            debounceTimer = setTimeout(() => {
                fetchResults(q);
            }, 300);
        });

        // ============================
        // FETCH RESULTS
        // ============================

        async function fetchResults(q) {
            try {
                const response = await fetch(`${searchUrl}?q=${encodeURIComponent(q)}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });

                if (!response.ok) throw new Error('Network error');

                const data = await response.json();

                renderResults(data, q);

            } catch (error) {
                console.error('Search error:', error);
                results.innerHTML = `
                    <div class="admin-search-no-result">
                        <i class="bi bi-exclamation-triangle"></i>
                        Terjadi kesalahan. Coba lagi.
                    </div>
                `;
            }
        }

        // ============================
        // RENDER RESULTS
        // ============================

        function renderResults(data, query) {
            currentItems = [];
            activeIndex = -1;

            if (!data.results || data.results.length === 0) {
                results.innerHTML = `
                    <div class="admin-search-no-result">
                        <i class="bi bi-search"></i>
                        Tidak ada hasil untuk "<strong>${escapeHtml(query)}</strong>"
                    </div>
                `;
                return;
            }

            let html = '';

            data.results.forEach((group) => {
                html += `<div class="admin-search-group">`;
                html += `
                    <div class="admin-search-group-title badge-${group.color}">
                        <i class="bi ${group.icon}"></i>
                        ${group.module}
                    </div>
                `;

                group.items.forEach((item) => {
                    const idx = currentItems.length;

                    currentItems.push({
                        url: item.url,
                        element: null,
                    });

                    html += `
                        <a href="${item.url}"
                           class="admin-search-item"
                           data-index="${idx}">
                            <div class="admin-search-item-icon">
                                <i class="bi ${group.icon}"></i>
                            </div>
                            <div class="admin-search-item-body">
                                <div class="admin-search-item-title">${highlight(item.title, query)}</div>
                                <div class="admin-search-item-subtitle">${highlight(item.subtitle || '', query)}</div>
                            </div>
                            <i class="bi bi-arrow-right admin-search-item-arrow"></i>
                        </a>
                    `;
                });

                html += `</div>`;
            });

            results.innerHTML = html;

            results.querySelectorAll('.admin-search-item').forEach((el, i) => {
                currentItems[i].element = el;

                el.addEventListener('mouseenter', () => {
                    setActive(i);
                });
            });
        }

        // ============================
        // KEYBOARD NAVIGATION
        // ============================

        input?.addEventListener('keydown', function (e) {
            if (currentItems.length === 0) return;

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                setActive(activeIndex + 1);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                setActive(activeIndex - 1);
            } else if (e.key === 'Enter') {
                e.preventDefault();
                if (activeIndex >= 0 && currentItems[activeIndex]) {
                    window.location.href = currentItems[activeIndex].url;
                }
            }
        });

        function setActive(index) {
            if (index < 0) index = currentItems.length - 1;
            if (index >= currentItems.length) index = 0;

            currentItems.forEach((item, i) => {
                item.element?.classList.toggle('active', i === index);
            });

            activeIndex = index;
            currentItems[index]?.element?.scrollIntoView({ block: 'nearest' });
        }

        // ============================
        // HELPERS
        // ============================

        function escapeHtml(str) {
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        function highlight(text, query) {
            if (!text) return '';

            const escaped = escapeHtml(text);

            if (!query) return escaped;

            const safeQuery = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
            const regex = new RegExp(`(${safeQuery})`, 'gi');

            return escaped.replace(regex, '<mark>$1</mark>');
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAdminSearch);
    } else {
        initAdminSearch();
    }

})();