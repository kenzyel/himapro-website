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

    AOS.init({
        duration: 600,
        easing: 'ease-out-cubic',
        once: true,
        offset: 40,
        delay: 0,
    });

    document.querySelectorAll('[data-countup]').forEach((el) => {
        const target = parseInt(el.dataset.countup, 10);
        if (Number.isNaN(target)) return;

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

    document.querySelectorAll('.alert-dismissible').forEach((alert) => {
        setTimeout(() => {
            alert.style.transition = 'opacity .4s ease, transform .4s ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 400);
        }, 5000);
    });

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
   SIDEBAR ADMIN TOGGLE — Desktop collapse + Mobile overlay
   ========================================================= */

(function () {
    const STORAGE_KEY = 'himapro-sidebar-collapsed';

    function isDesktop() {
        return window.innerWidth >= 768;
    }

    function applySavedState() {
        if (!isDesktop()) return;
        const collapsed = localStorage.getItem(STORAGE_KEY) === '1';
        if (collapsed) {
            document.body.classList.add('sidebar-collapsed');
        }
    }

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

    window.closeSidebar = function () {
        const sidebar = document.querySelector('.admin-sidebar');
        const overlay = document.getElementById('adminSidebarOverlay') ||
                        document.querySelector('.admin-sidebar-overlay');

        if (sidebar) sidebar.classList.remove('sidebar-open');

        if (overlay) {
            overlay.classList.remove('show');
            overlay.style.display = 'none';
        }

        document.body.classList.remove('sidebar-locked');
    };

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

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !isDesktop()) closeSidebar();
    });

    document.addEventListener('click', function (e) {
        if (isDesktop()) return;
        const link = e.target.closest('.admin-nav-link');
        if (link && !link.classList.contains('active')) {
            setTimeout(closeSidebar, 150);
        }
    });

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
   FRONTEND PUBLIK — Navbar Desktop + Sidebar Mobile
   ========================================================= */

(function () {
    function initFrontendNav() {
        const navbar = document.getElementById('feNavbar');
        const sidebar = document.getElementById('feMobileSidebar');
        const overlay = document.getElementById('feMobileOverlay');
        const toggle = document.getElementById('feMobileToggle');
        const closeBtn = document.getElementById('feMobileClose');

        // =====================
        // DESKTOP: scroll effect pada navbar
        // =====================
        if (navbar) {
            function handleScroll() {
                if (window.scrollY > 30) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            }

            window.addEventListener('scroll', handleScroll, { passive: true });
            handleScroll();
        }

        // =====================
        // MOBILE: sidebar drawer
        // =====================
        if (!sidebar) return;

        function openSidebar() {
            sidebar.classList.add('open');
            overlay?.classList.add('show');
            document.body.classList.add('menu-locked');
            document.body.classList.add('cursor-default'); // ← kursor asli kembali
            document.body.style.overflow = 'hidden';
            sidebar.setAttribute('aria-hidden', 'false');
        }

        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay?.classList.remove('show');
            document.body.classList.remove('menu-locked');
            document.body.classList.remove('cursor-default'); // ← kursor custom kembali
            document.body.style.overflow = '';
            sidebar.setAttribute('aria-hidden', 'true');
        }

        toggle?.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            openSidebar();
        });

        closeBtn?.addEventListener('click', function (e) {
            e.preventDefault();
            closeSidebar();
        });

        overlay?.addEventListener('click', closeSidebar);

        // Tutup sidebar saat klik link
        sidebar.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', closeSidebar);
        });

        // Tutup dengan ESC
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && sidebar.classList.contains('open')) {
                closeSidebar();
            }
        });

        // Reset saat resize ke desktop
        let resizeTimer;
        window.addEventListener('resize', function () {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function () {
                if (window.innerWidth >= 992) {
                    closeSidebar();
                }
            }, 150);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initFrontendNav);
    } else {
        initFrontendNav();
    }
})();


/* =========================================================
   FRONTEND — Particle Generator & Tilt
   ========================================================= */

document.addEventListener('DOMContentLoaded', function () {
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

                    currentItems.push({ url: item.url, element: null });

                    html += `
                        <a href="${item.url}" class="admin-search-item" data-index="${idx}">
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
                el.addEventListener('mouseenter', () => setActive(i));
            });
        }

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


/* =========================================================
   CYBER-FLUX CURSOR — Theme SAKTI
   - Kursor custom tetap aktif di laptop walaupun resize ke mobile
   - Dimatikan hanya di HP asli (touch-only) & reduced-motion
   - Saat sidebar mobile terbuka, class cursor-default ditambahkan
     ke body → kursor asli kembali, canvas disembunyikan
   ========================================================= */

(function () {
    function initCyberFluxCursor() {
        const canvas = document.getElementById('scene-canvas');
        const loader = document.getElementById('feLoader');

        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        if (!ctx) return;

        // Deteksi HP asli (touch-only), bukan berdasarkan innerWidth
        const isTouchOnly = window.matchMedia('(hover: none) and (pointer: coarse)').matches;

        if (isTouchOnly) {
            if (loader) loader.style.display = 'none';
            document.body.classList.add('cursor-default');
            return;
        }

        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            if (loader) loader.style.display = 'none';
            document.body.classList.add('cursor-default');
            return;
        }

        // Aktifkan kursor custom
        document.body.classList.remove('cursor-default');

        const cfg = {
            gridSpacing: 60,
            gridDistortion: 25,
            gridForceDist: 150,
            connectionDist: 110,
            particleCount: 60,
            cursorEase: 0.12,
            trailMax: 20,

            colorPrimary: '#FFD21A',
            colorSecondary: '#F5A900',
            colorGlitch: '#ff0055',
            colorGrid: 'rgba(255, 210, 26, 0.25)',
            colorParticle: 'rgba(255, 210, 26, 0.9)',
        };

        let width, height;
        const mouse = { x: window.innerWidth / 2, y: window.innerHeight / 2 };
        const cursor = { x: window.innerWidth / 2, y: window.innerHeight / 2 };
        const trail = [];
        let isHovering = false;
        let hoverTarget = null;
        let shake = 0;

        class GridPoint {
            constructor(x, y) {
                this.ox = x;
                this.oy = y;
                this.x = x;
                this.y = y;
                this.vx = 0;
                this.vy = 0;
            }

            update() {
                const dx = mouse.x - this.x;
                const dy = mouse.y - this.y;
                const dist = Math.sqrt(dx * dx + dy * dy);

                if (dist < cfg.gridForceDist) {
                    const force = (cfg.gridForceDist - dist) / cfg.gridForceDist;
                    const angle = Math.atan2(dy, dx);
                    this.vx -= Math.cos(angle) * force * 2;
                    this.vy -= Math.sin(angle) * force * 2;
                }

                this.vx += (this.ox - this.x) * 0.05;
                this.vy += (this.oy - this.y) * 0.05;
                this.vx *= 0.85;
                this.vy *= 0.85;
                this.x += this.vx;
                this.y += this.vy;
            }

            draw() {
                const size = Math.abs(this.ox - this.x) * 0.1 + 1;
                ctx.fillStyle = isHovering
                    ? 'rgba(255, 0, 85, 0.4)'
                    : cfg.colorGrid;
                ctx.fillRect(this.x, this.y, size, size);
            }
        }

        class Particle {
            constructor() { this.reset(); }

            reset() {
                this.x = Math.random() * width;
                this.y = Math.random() * height;
                this.vx = (Math.random() - 0.5) * 1.5;
                this.vy = (Math.random() - 0.5) * 1.5;
                this.size = Math.random() * 2 + 1;
            }

            update() {
                this.x += this.vx;
                this.y += this.vy;

                if (this.x < 0 || this.x > width) this.vx *= -1;
                if (this.y < 0 || this.y > height) this.vy *= -1;

                const dx = mouse.x - this.x;
                const dy = mouse.y - this.y;
                const dist = Math.sqrt(dx * dx + dy * dy);

                if (dist < 200 && dist > 0) {
                    this.x += dx * 0.01;
                    this.y += dy * 0.01;
                }
            }

            draw() {
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fillStyle = isHovering ? cfg.colorGlitch : cfg.colorPrimary;
                ctx.fill();
            }
        }

        let gridPoints = [];
        let particles = [];

        function init() {
            resize();
            gridPoints = [];

            const spacing = width < 768 ? 40 : cfg.gridSpacing;

            for (let y = 0; y < height; y += spacing) {
                for (let x = 0; x < width; x += spacing) {
                    gridPoints.push(new GridPoint(x, y));
                }
            }

            particles = [];
            const pCount = width < 768 ? 30 : cfg.particleCount;
            for (let i = 0; i < pCount; i++) {
                particles.push(new Particle());
            }
        }

        function resize() {
            width = canvas.width = window.innerWidth;
            height = canvas.height = window.innerHeight;
        }

        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                resize();
                init();
            }, 150);
        });

        document.addEventListener('mousemove', (e) => {
            mouse.x = e.clientX;
            mouse.y = e.clientY;

            const target = e.target.closest('.interactive-target, a, button, .fe-btn, .fe-nav-cta, .fe-nav-link, .fe-card, .fe-album-card, .fe-pengurus-card, .fe-mobile-toggle, .fe-mobile-nav-link, .fe-mobile-cta, .fe-mobile-sidebar-close');
            if (target) {
                isHovering = true;
                hoverTarget = target;
                if (!target.classList.contains('fe-glitch-active')) {
                    target.classList.add('fe-glitch-active');
                }
            } else {
                isHovering = false;
                hoverTarget = null;
                document.querySelectorAll('.fe-glitch-active').forEach((el) => {
                    el.classList.remove('fe-glitch-active');
                });
            }
        });

        document.addEventListener('mousedown', () => {
            shake = 10;
            particles.forEach((p) => {
                p.vx = (Math.random() - 0.5) * 20;
                p.vy = (Math.random() - 0.5) * 20;
            });
        });

        function drawLines() {
            for (let i = 0; i < particles.length; i++) {
                for (let j = i + 1; j < particles.length; j++) {
                    const dx = particles[i].x - particles[j].x;
                    const dy = particles[i].y - particles[j].y;
                    const dist = Math.sqrt(dx * dx + dy * dy);

                    if (dist < cfg.connectionDist) {
                        ctx.beginPath();
                        ctx.moveTo(particles[i].x, particles[i].y);
                        ctx.lineTo(particles[j].x, particles[j].y);
                        const alpha = 1 - dist / cfg.connectionDist;
                        ctx.strokeStyle = isHovering
                            ? `rgba(255, 0, 85, ${alpha * 0.5})`
                            : `rgba(255, 210, 26, ${alpha * 0.35})`;
                        ctx.lineWidth = 1;
                        ctx.stroke();
                    }
                }

                const dx = particles[i].x - cursor.x;
                const dy = particles[i].y - cursor.y;
                const dist = Math.sqrt(dx * dx + dy * dy);

                if (dist < cfg.connectionDist) {
                    ctx.beginPath();
                    ctx.moveTo(particles[i].x, particles[i].y);
                    ctx.lineTo(cursor.x, cursor.y);
                    const alpha = 1 - dist / cfg.connectionDist;
                    ctx.strokeStyle = `rgba(255, 255, 255, ${alpha * 0.5})`;
                    ctx.lineWidth = 0.5;
                    ctx.stroke();
                }
            }
        }

        function drawPolygon(x, y, radius, sides, rotation, color, lineWidth = 2) {
            ctx.beginPath();
            for (let i = 0; i < sides; i++) {
                const angle = rotation + (i * 2 * Math.PI / sides);
                const px = x + radius * Math.cos(angle);
                const py = y + radius * Math.sin(angle);
                i === 0 ? ctx.moveTo(px, py) : ctx.lineTo(px, py);
            }
            ctx.closePath();
            ctx.strokeStyle = color;
            ctx.lineWidth = lineWidth;
            ctx.stroke();
        }

        function drawCursor() {
            let targetX = mouse.x;
            let targetY = mouse.y;
            let magnetic = false;

            if (isHovering && hoverTarget) {
                const rect = hoverTarget.getBoundingClientRect();
                targetX += (rect.left + rect.width / 2 - targetX) * 0.3;
                targetY += (rect.top + rect.height / 2 - targetY) * 0.3;
                magnetic = true;
            }

            cursor.x += (targetX - cursor.x) * cfg.cursorEase;
            cursor.y += (targetY - cursor.y) * cfg.cursorEase;

            trail.push({ x: cursor.x, y: cursor.y });
            if (trail.length > cfg.trailMax) trail.shift();

            if (trail.length > 1) {
                ctx.beginPath();
                ctx.moveTo(trail[0].x, trail[0].y);

                for (let i = 1; i < trail.length - 1; i++) {
                    const xc = (trail[i].x + trail[i + 1].x) / 2;
                    const yc = (trail[i].y + trail[i + 1].y) / 2;
                    ctx.quadraticCurveTo(trail[i].x, trail[i].y, xc, yc);
                }

                const gradient = ctx.createLinearGradient(
                    trail[0].x, trail[0].y,
                    cursor.x, cursor.y
                );
                gradient.addColorStop(0, 'rgba(255, 210, 26, 0)');
                gradient.addColorStop(1, magnetic
                    ? 'rgba(255, 0, 85, 0.6)'
                    : 'rgba(255, 210, 26, 0.5)'
                );

                ctx.strokeStyle = gradient;
                ctx.lineWidth = magnetic ? 4 : 2;
                ctx.lineCap = 'round';
                ctx.stroke();
            }

            const time = Date.now() * 0.002;
            const size = magnetic ? 22 : 16;

            ctx.shadowBlur = 20;
            ctx.shadowColor = magnetic ? cfg.colorGlitch : cfg.colorPrimary;

            drawPolygon(cursor.x, cursor.y, size, 6, -time, magnetic ? cfg.colorGlitch : cfg.colorPrimary, 2);
            drawPolygon(cursor.x, cursor.y, size * 0.6, 3, time * 1.5, '#ffffff', 1.5);

            ctx.beginPath();
            ctx.arc(cursor.x, cursor.y, 2, 0, Math.PI * 2);
            ctx.fillStyle = '#fff';
            ctx.fill();

            ctx.shadowBlur = 0;
        }

        function animate() {
            let shakeX = 0, shakeY = 0;
            if (shake > 0) {
                shakeX = (Math.random() - 0.5) * shake;
                shakeY = (Math.random() - 0.5) * shake;
                shake *= 0.9;
                if (shake < 0.5) shake = 0;
            }

            ctx.save();
            ctx.clearRect(0, 0, width, height);
            ctx.translate(shakeX, shakeY);

            // Kalau menu mobile terbuka, kita skip render canvas
            // (kanvas juga di-hide oleh CSS via cursor-default)
            const menuOpen = document.body.classList.contains('menu-locked');

            if (!menuOpen) {
                gridPoints.forEach((p) => { p.update(); p.draw(); });
                particles.forEach((p) => { p.update(); p.draw(); });
                drawLines();
                drawCursor();
            }

            ctx.restore();
            requestAnimationFrame(animate);
        }

        init();
        animate();

        if (loader) {
            setTimeout(() => {
                loader.style.opacity = '0';
                setTimeout(() => loader.remove(), 1000);
            }, 500);
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCyberFluxCursor);
    } else {
        initCyberFluxCursor();
    }
})();


/* =========================================================
   SOCIAL MEDIA PARTICLES — Plexus di Section Social
   ========================================================= */

(function () {
    function initSocialParticles() {
        const canvas = document.getElementById('feSocialParticles');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        if (!ctx) return;

        if (window.innerWidth < 768) return;
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

        const CONFIG = {
            particleCount: 50,
            maxDistance: 140,
            particleRadius: 1.8,
            speed: 0.5,
            colors: {
                particle: 'rgba(255, 210, 26, 0.8)',
                line: 'rgba(255, 210, 26, ',
                particleGlow: 'rgba(255, 210, 26, 0.4)',
            },
        };

        let width, height;
        let particles = [];

        function resize() {
            const rect = canvas.getBoundingClientRect();
            const dpr = window.devicePixelRatio || 1;

            width = rect.width;
            height = rect.height;

            canvas.width = width * dpr;
            canvas.height = height * dpr;
            ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
        }

        class Particle {
            constructor() {
                this.x = Math.random() * width;
                this.y = Math.random() * height;
                this.vx = (Math.random() - 0.5) * CONFIG.speed;
                this.vy = (Math.random() - 0.5) * CONFIG.speed;
                this.radius = CONFIG.particleRadius;
            }

            move() {
                this.x += this.vx;
                this.y += this.vy;

                if (this.x < 0 || this.x > width) this.vx *= -1;
                if (this.y < 0 || this.y > height) this.vy *= -1;
            }

            draw() {
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.radius * 3, 0, Math.PI * 2);
                ctx.fillStyle = CONFIG.colors.particleGlow;
                ctx.fill();

                ctx.beginPath();
                ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
                ctx.fillStyle = CONFIG.colors.particle;
                ctx.fill();
            }
        }

        function connectParticles() {
            for (let i = 0; i < particles.length; i++) {
                for (let j = i + 1; j < particles.length; j++) {
                    const dx = particles[i].x - particles[j].x;
                    const dy = particles[i].y - particles[j].y;
                    const distance = Math.sqrt(dx * dx + dy * dy);

                    if (distance < CONFIG.maxDistance) {
                        const opacity = 0.5 * (1 - distance / CONFIG.maxDistance);
                        ctx.strokeStyle = CONFIG.colors.line + opacity + ')';
                        ctx.lineWidth = 0.8;

                        ctx.beginPath();
                        ctx.moveTo(particles[i].x, particles[i].y);
                        ctx.lineTo(particles[j].x, particles[j].y);
                        ctx.stroke();
                    }
                }
            }
        }

        function animate() {
            ctx.clearRect(0, 0, width, height);

            particles.forEach((p) => {
                p.move();
                p.draw();
            });

            connectParticles();
            requestAnimationFrame(animate);
        }

        function init() {
            resize();
            particles = [];
            for (let i = 0; i < CONFIG.particleCount; i++) {
                particles.push(new Particle());
            }
        }

        window.addEventListener('resize', () => {
            resize();
            init();
        });

        init();
        animate();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSocialParticles);
    } else {
        initSocialParticles();
    }
})();