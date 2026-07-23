(function initContactForm() {
  var form = document.getElementById('contactForm');
  if (!form) return;

  var statusEl = form.querySelector('.contact-form__status');
  var submitBtn = form.querySelector('.contact-form__submit');
  var i18n = window.PR_I18N || {};

  form.addEventListener('submit', function (e) {
    e.preventDefault();

    // Honeypot: si el campo oculto fue rellenado, es un bot. Descartar en silencio.
    if (form.botcheck && form.botcheck.value !== '') {
      return;
    }

    if (!form.checkValidity()) {
      form.reportValidity();
      return;
    }

    submitBtn.disabled = true;
    submitBtn.textContent = i18n.sending || 'Sending…';
    statusEl.textContent = '';
    statusEl.classList.remove('contact-form__status--success', 'contact-form__status--error');

    fetch('https://api.web3forms.com/submit', {
      method: 'POST',
      headers: { Accept: 'application/json' },
      body: new FormData(form),
    })
      .then(function (res) { return res.json(); })
      .then(function (data) {
        if (!data.success) throw new Error(data.message || 'submission error');
        statusEl.textContent = i18n.success || 'Thank you — your message has been sent.';
        statusEl.classList.add('contact-form__status--success');
        form.reset();
      })
      .catch(function () {
        statusEl.textContent = i18n.error || 'Something went wrong. Please try again.';
        statusEl.classList.add('contact-form__status--error');
      })
      .finally(function () {
        submitBtn.disabled = false;
        submitBtn.textContent = i18n.submitLabel || 'Send message';
      });
  });
})();
