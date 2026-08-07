(function () {
  var modal = document.getElementById('orderModal');
  if (!modal) return;

  var itemLabel   = document.getElementById('orderModalItem');
  var sizeWrap    = document.getElementById('orderModalSizeWrap');
  var sizeSelect  = document.getElementById('orderModalSize');
  var pricelist   = document.getElementById('orderModalPricelist');
  var lastFocused = null;
  var closeTimer  = null;
  var currentSizes = [];

  var i18n = {
    pickup:      modal.dataset.i18nPickup || 'Pickup',
    pickupHint:  modal.dataset.i18nPickupHint || '',
    estimate:    modal.dataset.i18nEstimate || 'est.',
    pickupOnly:  modal.dataset.i18nPickupOnly || ''
  };

  var PICKUP_ICON =
    '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">' +
    '<path d="M6 8h12l-1 12H7L6 8Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>' +
    '<path d="M9 8V6.5a3 3 0 0 1 6 0V8" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>' +
    '</svg>';

  function el(tag, className, text) {
    var node = document.createElement(tag);
    if (className) node.className = className;
    if (text !== undefined && text !== null) node.textContent = text;
    return node;
  }

  function buildPriceValue(price, isEstimate) {
    var wrap = el('span', 'order-modal__row-price');
    wrap.appendChild(document.createTextNode('$' + price));
    if (isEstimate) {
      var tag = el('span', 'order-modal__estimate', i18n.estimate);
      tag.setAttribute('title', i18n.estimate);
      wrap.appendChild(tag);
    }
    return wrap;
  }

  function buildPickupRow(sizeData) {
    var li = el('li', 'order-modal__row order-modal__row--pickup');

    var icon = el('span', 'order-modal__row-icon');
    icon.innerHTML = PICKUP_ICON;
    li.appendChild(icon);

    var text = el('span', 'order-modal__row-text');
    text.appendChild(el('span', 'order-modal__row-name', i18n.pickup));
    if (i18n.pickupHint) text.appendChild(el('span', 'order-modal__row-hint', i18n.pickupHint));
    li.appendChild(text);

    li.appendChild(el('span', 'order-modal__row-leader'));
    li.appendChild(buildPriceValue(sizeData.price, sizeData.priceIsEstimate));

    return li;
  }

  function buildPlatformRow(platform) {
    var li = el('li', 'order-modal__row');
    var link = document.createElement('a');
    link.className = 'order-modal__row-link';
    link.href = platform.url;
    link.target = '_blank';
    link.rel = 'noopener noreferrer';

    var icon = el('span', 'order-modal__row-icon');
    var img = document.createElement('img');
    img.src = platform.logo;
    img.alt = '';
    img.loading = 'lazy';
    img.width = 22;
    img.height = 22;
    icon.appendChild(img);
    link.appendChild(icon);

    link.appendChild(el('span', 'order-modal__row-name', platform.name));
    link.appendChild(el('span', 'order-modal__row-leader'));
    link.appendChild(buildPriceValue(platform.price, platform.isEstimate));

    li.appendChild(link);
    return li;
  }

  function renderPricelist(sizeData) {
    pricelist.innerHTML = '';
    if (!sizeData) return;

    pricelist.appendChild(buildPickupRow(sizeData));

    (sizeData.platforms || []).forEach(function (platform) {
      pricelist.appendChild(buildPlatformRow(platform));
    });

    if ((!sizeData.platforms || sizeData.platforms.length === 0) && i18n.pickupOnly) {
      var note = el('li', 'order-modal__pickup-note', i18n.pickupOnly);
      pricelist.appendChild(note);
    }
  }

  function onSizeChange() {
    var idx = sizeSelect.selectedIndex;
    renderPricelist(currentSizes[idx]);
  }

  function setupSizes(sizes) {
    currentSizes = sizes || [];
    sizeSelect.innerHTML = '';

    var hasRealSizes = currentSizes.length > 1 && currentSizes[0].label;
    sizeWrap.hidden = !hasRealSizes;

    if (hasRealSizes) {
      currentSizes.forEach(function (s, i) {
        var option = document.createElement('option');
        option.value = String(i);
        option.textContent = s.label;
        sizeSelect.appendChild(option);
      });
      sizeSelect.selectedIndex = 0;
    }

    renderPricelist(currentSizes[0]);
  }

  function openModal(payload) {
    clearTimeout(closeTimer);
    lastFocused = document.activeElement;
    if (itemLabel) itemLabel.textContent = payload.name || '';
    setupSizes(payload.sizes || []);

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

  function payloadFromTrigger(trigger) {
    try {
      return JSON.parse(trigger.dataset.orderPayload || '{}');
    } catch (e) {
      return { name: trigger.dataset.orderName || '', sizes: [] };
    }
  }

  document.querySelectorAll('[data-order-trigger]').forEach(function (trigger) {
    trigger.addEventListener('click', function () {
      openModal(payloadFromTrigger(trigger));
    });
    trigger.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        openModal(payloadFromTrigger(trigger));
      }
    });
  });

  sizeSelect.addEventListener('change', onSizeChange);

  modal.querySelectorAll('[data-order-close]').forEach(function (el) {
    el.addEventListener('click', closeModal);
  });
})();
