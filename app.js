/* Lumoo Coffee - Smooth Animations & Mobile Interactions */
(function () {
  'use strict';

  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  function initScrollReveal() {
    const selectors = [
      '.about-left',
      '.about-right',
      '.bs-title',
      '.product-card',
      '.load-btn',
      '.mading-inner',
      '.mission .col-left',
      '.mission .col-right',
      '.values .col-left',
      '.values .col-right',
      '.stat',
      '.poster',
      '.filters-wrap',
      '.menus-section .section-title',
      '.location-section-title',
      '.location-card',
      '.location-promo-image',
      '.contact-hero-copy',
      '.contact-card',
      '.contact-form-card',
      '.footer-top',
      '.dashboard-cards .card',
      '.admin-card',
      '.message-card'
    ];

    const targets = Array.from(document.querySelectorAll(selectors.join(', ')));
    if (!targets.length) return;

    if (prefersReducedMotion || !('IntersectionObserver' in window)) {
      return;
    }

    const staggerGroups = new Map();

    targets.forEach((el) => {
      el.classList.add('reveal');

      const parent = el.parentElement;
      if (
        parent &&
        parent.matches(
          '.product-grid, .location-grid, .stats-row, .poster-row, .contact-left, .dashboard-cards, .message-cards-container'
        )
      ) {
        const idx = staggerGroups.get(parent) || 0;
        staggerGroups.set(parent, idx + 1);
        const delayMs = Math.min(idx * 65, 260);
        el.style.transitionDelay = delayMs + 'ms';
      }
    });

    const observer = new IntersectionObserver(
      (entries, obs) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            obs.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.08, rootMargin: '0px 0px -24px 0px' }
    );

    targets.forEach((el) => observer.observe(el));

    // Safety fallback: ensure elements already in viewport on load appear immediately
    requestAnimationFrame(() => {
      const vh = window.innerHeight || document.documentElement.clientHeight;
      targets.forEach((el) => {
        const rect = el.getBoundingClientRect();
        if (rect.top < vh * 0.95) {
          el.classList.add('is-visible');
          observer.unobserve(el);
        }
      });
    });
  }

  function initNavbar() {
    const navbar = document.querySelector('.navbar');
    const navToggle = document.getElementById('nav-toggle');
    const hamburger = document.querySelector('.hamburger');
    const navLinks = document.querySelector('.nav-links');
    const userDropdown = document.getElementById('userDropdown');

    if (navbar) {
      const onScroll = () => {
        navbar.classList.toggle('scrolled', window.scrollY > 12);
      };
      window.addEventListener('scroll', onScroll, { passive: true });
      onScroll();
    }

    if (hamburger && navToggle) {
      hamburger.setAttribute('role', 'button');
      hamburger.setAttribute('aria-label', 'Toggle navigation menu');
      hamburger.setAttribute('aria-expanded', 'false');

      navToggle.addEventListener('change', () => {
        hamburger.setAttribute('aria-expanded', navToggle.checked ? 'true' : 'false');
      });

      if (navLinks) {
        navLinks.querySelectorAll('a').forEach((link) => {
          link.addEventListener('click', () => {
            navToggle.checked = false;
            hamburger.setAttribute('aria-expanded', 'false');
          });
        });
      }

      document.addEventListener('click', (e) => {
        if (navToggle.checked && navbar && !navbar.contains(e.target)) {
          navToggle.checked = false;
          hamburger.setAttribute('aria-expanded', 'false');
        }
      });
    }

    if (userDropdown) {
      document.addEventListener('click', (e) => {
        if (!userDropdown.contains(e.target)) {
          userDropdown.classList.remove('open');
        }
      });
    }

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        if (navToggle && navToggle.checked) {
          navToggle.checked = false;
          if (hamburger) hamburger.setAttribute('aria-expanded', 'false');
        }
        if (userDropdown) {
          userDropdown.classList.remove('open');
        }
        document.body.classList.remove('sidebar-open');
      }
    });
  }

  function initMenuUrlFilter() {
    const filterBar = document.getElementById('filter-bar');
    if (!filterBar) return;
    const params = new URLSearchParams(window.location.search);
    const kat = params.get('kat');
    if (!kat) return;

    const btn = filterBar.querySelector('.filter-btn[data-cat="' + CSS.escape(kat) + '"]');
    if (btn) {
      btn.click();
    }
  }

  function initAdminSidebar() {
    const sidebar = document.querySelector('.sidebar');
    if (!sidebar) return;

    // Highlight active sidebar link
    const currentFile = window.location.pathname.split('/').pop();
    sidebar.querySelectorAll('ul li a').forEach((link) => {
      const href = (link.getAttribute('href') || '').split('/').pop();
      if (href && href === currentFile) {
        link.classList.add('active');
      }
    });

    // Create backdrop for mobile drawer
    const backdrop = document.createElement('div');
    backdrop.className = 'sidebar-backdrop';
    document.body.appendChild(backdrop);

    const toggleSidebar = () => {
      document.body.classList.toggle('sidebar-open');
    };

    const closeSidebar = () => {
      document.body.classList.remove('sidebar-open');
    };

    const header = document.querySelector('.header');
    let barsIcon = header ? header.querySelector('.fa-bars') : null;

    if (barsIcon) {
      barsIcon.classList.add('mobile-menu-trigger');
      barsIcon.setAttribute('role', 'button');
      barsIcon.setAttribute('aria-label', 'Toggle sidebar menu');
      barsIcon.addEventListener('click', toggleSidebar);
    } else if (header) {
      const btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'mobile-menu-btn';
      btn.setAttribute('aria-label', 'Toggle sidebar menu');
      btn.innerHTML = '<i class="fas fa-bars"></i>';
      btn.addEventListener('click', toggleSidebar);
      header.insertBefore(btn, header.firstChild);
    }

    backdrop.addEventListener('click', closeSidebar);
    sidebar.querySelectorAll('a').forEach((a) => {
      a.addEventListener('click', () => {
        if (window.innerWidth <= 900) closeSidebar();
      });
    });
  }

  function init() {
    initScrollReveal();
    initNavbar();
    initMenuUrlFilter();
    initAdminSidebar();
  }

  // Jika halaman dipulihkan dari back-forward cache (mis. tekan Back setelah logout),
  // muat ulang dari server supaya pengecekan login dijalankan lagi.
  window.addEventListener('pageshow', (e) => {
    if (e.persisted) {
      window.location.reload();
    }
  });

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
