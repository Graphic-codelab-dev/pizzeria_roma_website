(function () {
  var modal = document.getElementById('orderModal');
  if (!modal) return;

  var itemLabel = document.getElementById('orderModalItem');
  var lastFocused = null;

  function openModal(name) {
    lastFocused = document.activeElement;
    if (itemLabel) itemLabel.textContent = name || '';
    modal.hidden = false;
    document.body.classList.add('order-modal-open');
    var closeBtn = modal.querySelector('.order-modal__close');
    if (closeBtn) closeBtn.focus();
    document.addEventListener('keydown', onKeydown);
  }

  function closeModal() {
    modal.hidden = true;
    document.body.classList.remove('order-modal-open');
    document.removeEventListener('keydown', onKeydown);
    if (lastFocused) lastFocused.focus();
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
