(function initMobileNav() {
  var toggle = document.getElementById('navToggle');
  var nav = document.getElementById('mobileNav');
  if (!toggle || !nav) return;

  toggle.addEventListener('click', function () {
    var isOpen = toggle.getAttribute('aria-expanded') === 'true';
    toggle.setAttribute('aria-expanded', String(!isOpen));
    nav.hidden = isOpen;
    document.body.classList.toggle('nav-open', !isOpen);
  });

  nav.querySelectorAll('a').forEach(function (link) {
    link.addEventListener('click', function () {
      toggle.setAttribute('aria-expanded', 'false');
      nav.hidden = true;
      document.body.classList.remove('nav-open');
    });
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
