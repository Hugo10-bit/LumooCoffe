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

  function initNotifications() {
    if (typeof Swal === 'undefined') return;

    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3500,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
      }
    });

    // 1. Check URL query parameters for feedback notifications
    const params = new URLSearchParams(window.location.search);
    const notif = params.get('notif');
    const pesan = params.get('pesan');

    if (notif === 'edit_sukses') {
      Toast.fire({
        icon: 'success',
        title: 'Perubahan data berhasil disimpan! ✨'
      });
    } else if (notif === 'tambah_sukses') {
      Toast.fire({
        icon: 'success',
        title: 'Data baru berhasil ditambahkan! 🎉'
      });
    } else if (notif === 'hapus_sukses') {
      Toast.fire({
        icon: 'success',
        title: 'Data berhasil dihapus! 🗑️'
      });
    } else if (notif === 'password_sukses') {
      Toast.fire({
        icon: 'success',
        title: 'Password akun berhasil diperbarui! 🔒'
      });
    } else if (notif === 'demo_mode') {
      Swal.fire({
        icon: 'info',
        title: 'Mode Demo Cloud Aktif',
        text: 'Database belum terhubung ke cloud. Aksi disimulasikan pada sesi saat ini.',
        confirmButtonColor: '#382814',
        confirmButtonText: 'Mengerti'
      });
    }

    if (pesan === 'logout') {
      Swal.fire({
        icon: 'info',
        title: 'Berhasil Logout',
        text: 'Anda telah berhasil keluar dari akun. Silakan login kembali.',
        confirmButtonColor: '#382814',
        confirmButtonText: 'OK'
      });
    } else if (pesan === 'login') {
      Swal.fire({
        icon: 'warning',
        title: 'Sesi Diperlukan',
        text: 'Sesi Anda telah berakhir atau Anda belum login. Silakan masuk terlebih dahulu.',
        confirmButtonColor: '#382814',
        confirmButtonText: 'Masuk Sekarang'
      });
    } else if (pesan === 'registered') {
      Swal.fire({
        icon: 'success',
        title: 'Registrasi Berhasil',
        text: 'Akun Anda berhasil didaftarkan! Silakan login untuk melanjutkan.',
        confirmButtonColor: '#382814',
        confirmButtonText: 'Login Sekarang'
      });
    }

    // Clean up URL params so refreshing doesn't replay alerts
    if (notif || pesan) {
      const cleanUrl = window.location.pathname;
      window.history.replaceState({}, document.title, cleanUrl);
    }

    // 2. Global event delegation for Logout links
    document.addEventListener('click', (e) => {
      const logoutLink = e.target.closest('a[href*="logout"]');
      if (logoutLink) {
        e.preventDefault();
        const targetUrl = logoutLink.getAttribute('href');
        Swal.fire({
          title: 'Konfirmasi Logout',
          text: 'Apakah Anda yakin ingin keluar? Anda harus login kembali untuk mengakses akun.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#382814',
          cancelButtonColor: '#9ca3af',
          confirmButtonText: '<i class="fas fa-sign-out-alt"></i> Ya, Logout',
          cancelButtonText: 'Batal',
          reverseButtons: true,
          focusCancel: true
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = targetUrl;
          }
        });
        return;
      }

      // 3. Global event delegation for Hapus (Delete) links
      const deleteLink = e.target.closest('a[href*="hapus_proses"], a.delete, a.delete-btn');
      if (deleteLink) {
        e.preventDefault();
        const targetUrl = deleteLink.getAttribute('href');
        const row = deleteLink.closest('tr') || deleteLink.closest('.message-card');
        let itemName = '';
        if (row) {
          const nameEl = row.querySelector('strong') || row.querySelector('.cat-name-highlight') || row.querySelector('.msg-sender');
          if (nameEl) itemName = nameEl.innerText.trim();
        }

        Swal.fire({
          title: 'Konfirmasi Hapus Data',
          html: itemName 
            ? 'Apakah Anda yakin ingin menghapus <strong>"' + itemName + '"</strong>?<br><span style="color:#ef4444; font-size:13px; font-weight:600;"><i class="fas fa-exclamation-triangle"></i> Tindakan ini tidak dapat dibatalkan!</span>'
            : 'Apakah Anda yakin ingin menghapus data ini?<br><span style="color:#ef4444; font-size:13px; font-weight:600;"><i class="fas fa-exclamation-triangle"></i> Tindakan ini tidak dapat dibatalkan!</span>',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#dc2626',
          cancelButtonColor: '#9ca3af',
          confirmButtonText: '<i class="fas fa-trash-alt"></i> Ya, Hapus Data',
          cancelButtonText: 'Batal',
          reverseButtons: true,
          focusCancel: true
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = targetUrl;
          }
        });
        return;
      }

      // 4. Global event delegation for Toggle Best Seller
      const bsToggle = e.target.closest('a[href*="toggle_bs"]');
      if (bsToggle) {
        e.preventDefault();
        const targetUrl = bsToggle.getAttribute('href');
        const isCurrentlyBS = bsToggle.classList.contains('bs-on');
        const title = isCurrentlyBS ? 'Lepas Best Seller?' : 'Jadikan Best Seller?';
        const text = isCurrentlyBS 
          ? 'Produk ini tidak akan lagi ditampilkan pada slot Best Seller di beranda.'
          : 'Produk ini akan disorot pada slot Best Seller di beranda kafe.';

        Swal.fire({
          title: title,
          text: text,
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#d97706',
          cancelButtonColor: '#9ca3af',
          confirmButtonText: isCurrentlyBS ? 'Ya, Lepas Status' : 'Ya, Jadikan Best Seller',
          cancelButtonText: 'Batal',
          reverseButtons: true
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = targetUrl;
          }
        });
        return;
      }
    });

    // 5. Intercept Form Submit on Edit / Profile forms
    document.querySelectorAll('form').forEach((form) => {
      const h3 = form.querySelector('h3');
      if (!h3) return;
      const title = h3.innerText.toLowerCase();
      const isEdit = title.includes('edit') || title.includes('profile') || title.includes('password');
      if (!isEdit) return;

      form.addEventListener('submit', function (e) {
        if (form.dataset.confirmed === 'true') return;

        e.preventDefault();
        const isPw = title.includes('password');
        const confirmTitle = isPw ? 'Ubah Password Akun?' : 'Simpan Perubahan Data?';
        const confirmText = isPw 
          ? 'Pastikan Anda mengingat password baru yang dimasukkan.' 
          : 'Apakah data perubahan yang Anda masukkan sudah benar?';

        Swal.fire({
          title: confirmTitle,
          text: confirmText,
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#382814',
          cancelButtonColor: '#9ca3af',
          confirmButtonText: '<i class="fas fa-check"></i> Ya, Simpan',
          cancelButtonText: 'Periksa Lagi',
          reverseButtons: true
        }).then((result) => {
          if (result.isConfirmed) {
            form.dataset.confirmed = 'true';
            // Find submit button to preserve its name in POST
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn && submitBtn.name) {
              const hidden = document.createElement('input');
              hidden.type = 'hidden';
              hidden.name = submitBtn.name;
              hidden.value = '1';
              form.appendChild(hidden);
            }
            form.submit();
          }
        });
      });
    });
  }

  function init() {
    initScrollReveal();
    initNavbar();
    initMenuUrlFilter();
    initAdminSidebar();
    initNotifications();
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
