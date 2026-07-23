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
    closeTimer = setTimeout(function () {
      nav.hidden = true;
    }, 260);
  }

  toggle.addEventListener('click', function () {
    var isOpen = toggle.getAttribute('aria-expanded') === 'true';
    if (isOpen) {
      closeNav();
    } else {
      openNav();
    }
  });

  nav.querySelectorAll('a').forEach(function (link) {
    link.addEventListener('click', closeNav);
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
