(function initAdminNav() {
  var toggle = document.getElementById('adminNavToggle');
  var nav = document.getElementById('adminNav');
  if (!toggle || !nav) return;

  toggle.addEventListener('click', function () {
    var isOpen = nav.classList.toggle('is-open');
    toggle.setAttribute('aria-expanded', String(isOpen));
  });
})();

(function initAutosubmit() {
  document.querySelectorAll('[data-autosubmit]').forEach(function (field) {
    field.addEventListener('change', function () {
      field.form.submit();
    });
  });
})();

(function initConfirmForms() {
  document.querySelectorAll('[data-confirm]').forEach(function (form) {
    form.addEventListener('submit', function (e) {
      if (!window.confirm(form.getAttribute('data-confirm'))) {
        e.preventDefault();
      }
    });
  });
})();
