(function initMobileNav() {
  var toggle = document.getElementById('navToggle');
  var nav = document.getElementById('mobileNav');
  if (!toggle || !nav) return;

  var closeTimer = null;

  function openNav() {
    clearTimeout(closeTimer);
    toggle.setAttribute('aria-expanded', 'true');
    nav.hidden = false;
    document.body.classList.add('nav-open');
    // Deja que el navegador pinte con display activo antes de animar,
    // si no, la transición de opacity/transform no se dispara.
    requestAnimationFrame(function () {
      requestAnimationFrame(function () {
        nav.classList.add('is-open');
      });
    });
  }

  function closeNav() {
    clearTimeout(closeTimer);
    toggle.setAttribute('aria-expanded', 'false');
    nav.classList.remove('is-open');
    document.body.classList.remove('nav-open');
    document.removeEventListener('keydown', onKeydown);
    closeTimer = setTimeout(function () {
      nav.hidden = true;
    }, 260);
    toggle.focus();
  }

  function onKeydown(e) {
    if (e.key === 'Escape') closeNav();
  }

  toggle.addEventListener('click', function () {
    var isOpen = toggle.getAttribute('aria-expanded') === 'true';
    if (isOpen) {
      closeNav();
    } else {
      openNav();
      document.addEventListener('keydown', onKeydown);
    }
  });

  nav.querySelectorAll('[data-nav-close]').forEach(function (el) {
    el.addEventListener('click', closeNav);
  });

  nav.querySelectorAll('a').forEach(function (link) {
    link.addEventListener('click', closeNav);
  });
})();

(function initPageTransitions() {
  // Navegadores con View Transitions nativas (cross-document) ya resuelven
  // la transición entre páginas sin JS — ver @view-transition en animations.css.
  if ('startViewTransition' in document) return;

  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

  var EXIT_DELAY = 260; // debe calzar con --duration-base

  document.addEventListener('click', function (e) {
    if (e.defaultPrevented || e.button !== 0) return;
    if (e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;

    var link = e.target.closest('a[href]');
    if (!link || link.hasAttribute('download')) return;
    if (link.target && link.target !== '_self') return;

    var url;
    try {
      url = new URL(link.href, window.location.href);
    } catch (err) {
      return;
    }

    if (url.protocol !== 'http:' && url.protocol !== 'https:') return;
    if (url.origin !== window.location.origin) return;
    // Ancla dentro de la misma página: deja el scroll suave nativo intacto.
    if (url.pathname === window.location.pathname && url.hash) return;

    e.preventDefault();
    document.body.classList.add('is-leaving');
    window.setTimeout(function () {
      window.location.href = link.href;
    }, EXIT_DELAY);
  });
})();

(function initHeaderScrollState() {
  var header = document.querySelector('.site-header');
  if (!header) return;

  var onScroll = function () {
    header.classList.toggle('site-header--scrolled', window.scrollY > 12);
  };

  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();
})();
