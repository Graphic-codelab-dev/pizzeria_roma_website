(function () {
  var modal = document.getElementById('orderModal');
  if (!modal) return;

  var itemLabel = document.getElementById('orderModalItem');
  var lastFocused = null;
  var closeTimer = null;

  function openModal(name) {
    clearTimeout(closeTimer);
    lastFocused = document.activeElement;
    if (itemLabel) itemLabel.textContent = name || '';
    modal.hidden = false;
    document.body.classList.add('order-modal-open');
    // Doble rAF: deja que el navegador pinte con display activo antes
    // de animar, si no, la transición de opacity/transform no se dispara.
    requestAnimationFrame(function () {
      requestAnimationFrame(function () {
        modal.classList.add('is-open');
      });
    });
    var closeBtn = modal.querySelector('.order-modal__close');
    if (closeBtn) closeBtn.focus();
    document.addEventListener('keydown', onKeydown);
  }

  function closeModal() {
    clearTimeout(closeTimer);
    modal.classList.remove('is-open');
    document.body.classList.remove('order-modal-open');
    document.removeEventListener('keydown', onKeydown);
    if (lastFocused) lastFocused.focus();
    closeTimer = setTimeout(function () {
      modal.hidden = true;
    }, 260);
  }

  function onKeydown(e) {
    if (e.key === 'Escape') closeModal();
  }

  document.querySelectorAll('[data-order-trigger]').forEach(function (trigger) {
    trigger.addEventListener('click', function () {
      openModal(trigger.dataset.orderName);
    });
    trigger.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        openModal(trigger.dataset.orderName);
      }
    });
  });

  modal.querySelectorAll('[data-order-close]').forEach(function (el) {
    el.addEventListener('click', closeModal);
  });
})();
