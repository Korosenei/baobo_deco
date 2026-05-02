/**
 * BAOBO DECO — baobo-main.js v2.0
 * Header & Footer : scroll effect, hamburger, recherche, bandeau promo,
 * back-to-top, WhatsApp tooltip, compteur panier WooCommerce
 */
(function () {
  'use strict';

  /* ══════════════════════════════════════════
     UTILITAIRES
  ══════════════════════════════════════════ */
  const $ = (s, ctx = document) => ctx.querySelector(s);
  const $$ = (s, ctx = document) => [...ctx.querySelectorAll(s)];

  /* ══════════════════════════════════════════
     1. HEADER — Effet scroll
  ══════════════════════════════════════════ */
  function initHeaderScroll() {
    const header = $('#bdHeader');
    if (!header) return;

    let ticking = false;

    window.addEventListener('scroll', () => {
      if (!ticking) {
        requestAnimationFrame(() => {
          header.classList.toggle('bd-scrolled', window.scrollY > 60);
          ticking = false;
        });
        ticking = true;
      }
    }, { passive: true });
  }

  /* ══════════════════════════════════════════
     2. BANDEAU PROMO — Fermeture
  ══════════════════════════════════════════ */
  function initTopbar() {
    const topbar = $('#bdTopbar');
    const closeBtn = $('#bdTopbarClose');
    if (!topbar || !closeBtn) return;

    closeBtn.addEventListener('click', () => {
      topbar.style.transition = 'max-height .4s ease, opacity .4s ease';
      topbar.style.maxHeight = '0';
      topbar.style.opacity = '0';
      topbar.style.overflow = 'hidden';
      setTimeout(() => {
        topbar.hidden = true;
        topbar.style.display = 'none';
        // Mémoriser dans sessionStorage pour ne pas réafficher
        sessionStorage.setItem('bdPromoClosed', '1');
      }, 420);
    });

    // Si fermé précédemment dans cette session
    if (sessionStorage.getItem('bdPromoClosed') === '1') {
      topbar.hidden = true;
      topbar.style.display = 'none';
    }
  }

  /* ══════════════════════════════════════════
     3. HAMBURGER + MENU MOBILE
  ══════════════════════════════════════════ */
  function initMobileMenu() {
    const hamburger   = $('#bdHamburger');
    const mobileMenu  = $('#bdMobileMenu');
    const overlay     = $('#bdMobileOverlay');
    const closeBtn    = $('#bdMobileClose');
    if (!hamburger || !mobileMenu) return;

    function openMenu() {
      mobileMenu.classList.add('open');
      mobileMenu.setAttribute('aria-hidden', 'false');
      hamburger.classList.add('open');
      hamburger.setAttribute('aria-expanded', 'true');
      hamburger.setAttribute('aria-label', 'Fermer le menu');
      document.body.style.overflow = 'hidden';
    }

    function closeMenu() {
      mobileMenu.classList.remove('open');
      mobileMenu.setAttribute('aria-hidden', 'true');
      hamburger.classList.remove('open');
      hamburger.setAttribute('aria-expanded', 'false');
      hamburger.setAttribute('aria-label', 'Ouvrir le menu');
      document.body.style.overflow = '';
    }

    hamburger.addEventListener('click', () => {
      mobileMenu.classList.contains('open') ? closeMenu() : openMenu();
    });

    closeBtn?.addEventListener('click', closeMenu);
    overlay?.addEventListener('click', closeMenu);

    // Fermer avec Escape
    document.addEventListener('keydown', e => {
      if (e.key === 'Escape' && mobileMenu.classList.contains('open')) closeMenu();
    });

    // Fermer si on clique sur un lien mobile
    $$('.bd-mobile-nav-link', mobileMenu).forEach(link => {
      link.addEventListener('click', closeMenu);
    });
  }

  /* ══════════════════════════════════════════
     4. BARRE DE RECHERCHE
  ══════════════════════════════════════════ */
  function initSearch() {
    const toggleBtn  = $('#bdSearchToggle');
    const searchBar  = $('#bdSearchBar');
    const closeBtn   = $('#bdSearchClose');
    const input      = $('#bdSearchInput');
    if (!toggleBtn || !searchBar) return;

    function openSearch() {
      searchBar.classList.add('open');
      searchBar.setAttribute('aria-hidden', 'false');
      // Focus avec un léger délai pour l'animation
      setTimeout(() => input?.focus(), 150);
    }

    function closeSearch() {
      searchBar.classList.remove('open');
      searchBar.setAttribute('aria-hidden', 'true');
    }

    toggleBtn.addEventListener('click', () => {
      searchBar.classList.contains('open') ? closeSearch() : openSearch();
    });

    closeBtn?.addEventListener('click', closeSearch);

    // Fermer avec Escape
    document.addEventListener('keydown', e => {
      if (e.key === 'Escape' && searchBar.classList.contains('open')) {
        closeSearch();
        toggleBtn.focus();
      }
    });

    // Fermer en cliquant hors de la barre
    document.addEventListener('click', e => {
      if (searchBar.classList.contains('open') &&
          !searchBar.contains(e.target) &&
          !toggleBtn.contains(e.target)) {
        closeSearch();
      }
    });
  }

  /* ══════════════════════════════════════════
     5. BACK TO TOP
  ══════════════════════════════════════════ */
  function initBackToTop() {
    const btn = $('#bdToTop');
    if (!btn) return;

    window.addEventListener('scroll', () => {
      btn.classList.toggle('visible', window.scrollY > 400);
    }, { passive: true });

    btn.addEventListener('click', e => {
      e.preventDefault();
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  /* ══════════════════════════════════════════
     6. WHATSAPP TOOLTIP AUTO
  ══════════════════════════════════════════ */
  function initWATooltip() {
    const tooltip = $('.bd-wa-tooltip');
    if (!tooltip) return;

    // Affichage automatique après 4 secondes
    setTimeout(() => {
      tooltip.style.opacity = '1';
      setTimeout(() => {
        tooltip.style.opacity = '';
      }, 3500);
    }, 4000);
  }

  /* ══════════════════════════════════════════
     7. SCROLL REVEAL (sections globales)
  ══════════════════════════════════════════ */
  function initReveal() {
    if (!('IntersectionObserver' in window)) {
      $$('.bd-reveal').forEach(el => el.classList.add('bd-visible'));
      return;
    }

    const obs = new IntersectionObserver((entries) => {
      entries.forEach(e => {
        if (e.isIntersecting) {
          e.target.classList.add('bd-visible');
          obs.unobserve(e.target);
        }
      });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

    $$('.bd-reveal').forEach(el => obs.observe(el));
  }

  /* Ré-observer après AJAX (filtres, WooCommerce) */
  function reObserveReveal() {
    const obs = new IntersectionObserver((entries) => {
      entries.forEach(e => {
        if (e.isIntersecting) {
          e.target.classList.add('bd-visible');
          obs.unobserve(e.target);
        }
      });
    }, { threshold: 0.1 });
    $$('.bd-reveal:not(.bd-visible)').forEach(el => obs.observe(el));
  }

  /* ══════════════════════════════════════════
     8. PANIER WOOCOMMERCE — Animation badge
  ══════════════════════════════════════════ */
  function initCartAnimation() {
    const style = document.createElement('style');
    style.textContent = '@keyframes bdBadgeBounce { 0%,100%{transform:scale(1)} 50%{transform:scale(1.6)} }';
    document.head.appendChild(style);

    document.body.addEventListener('added_to_cart', () => {
      const badge = $('#bdCartCount');
      if (!badge) return;
      badge.style.display = 'flex';
      badge.style.animation = 'none';
      requestAnimationFrame(() => {
        requestAnimationFrame(() => {
          badge.style.animation = 'bdBadgeBounce .45s ease';
        });
      });
    });
  }

  /* ══════════════════════════════════════════
     9. SMOOTH SCROLL pour ancres internes
  ══════════════════════════════════════════ */
  function initSmoothScroll() {
    $$('a[href^="#"]').forEach(a => {
      a.addEventListener('click', e => {
        const id = a.getAttribute('href');
        if (id === '#') return;
        const target = document.querySelector(id);
        if (!target) return;
        e.preventDefault();
        const headerH = $('#bdHeader')?.offsetHeight || 80;
        window.scrollTo({
          top: target.getBoundingClientRect().top + window.scrollY - headerH - 10,
          behavior: 'smooth'
        });
      });
    });
  }

  /* ══════════════════════════════════════════
     10. LAZY IMAGES — fondu à l'apparition
  ══════════════════════════════════════════ */
  function initLazyFade() {
    if (!('IntersectionObserver' in window)) return;

    const style = document.createElement('style');
    style.textContent = `
      img[loading="lazy"] { opacity: 0; transition: opacity .55s ease; }
      img[loading="lazy"].bd-img-loaded { opacity: 1; }
    `;
    document.head.appendChild(style);

    const obs = new IntersectionObserver(entries => {
      entries.forEach(e => {
        if (!e.isIntersecting) return;
        const img = e.target;
        const onLoad = () => img.classList.add('bd-img-loaded');
        img.complete ? onLoad() : img.addEventListener('load', onLoad, { once: true });
        obs.unobserve(img);
      });
    }, { rootMargin: '200px' });

    $$('img[loading="lazy"]').forEach(img => obs.observe(img));
  }

  /* ══════════════════════════════════════════
     11. ADMIN BAR OFFSET
  ══════════════════════════════════════════ */
  function fixAdminBarOffset() {
    const adminBar = document.getElementById('wpadminbar');
    const header   = document.getElementById('bdHeader');
    if (!adminBar || !header) return;

    function applyOffset() {
      header.style.top = adminBar.offsetHeight + 'px';
    }
    applyOffset();
    window.addEventListener('resize', applyOffset, { passive: true });
  }

  /* ══════════════════════════════════════════
     INIT — DOMContentLoaded
  ══════════════════════════════════════════ */
  document.addEventListener('DOMContentLoaded', () => {
    initHeaderScroll();
    initTopbar();
    initMobileMenu();
    initSearch();
    initBackToTop();
    initReveal();
    initSmoothScroll();
    initLazyFade();
    fixAdminBarOffset();
    setTimeout(initWATooltip, 500);

    // WooCommerce
    if (typeof wc_add_to_cart_params !== 'undefined') {
      initCartAnimation();
    }
  });

  // Re-check après requêtes AJAX (WooCommerce, filtres)
  document.addEventListener('ajaxComplete', reObserveReveal);

})();
