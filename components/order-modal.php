<?php
/**
 * Popup de pedido: se abre al hacer click en un platillo del menú.
 * Muestra el selector de tamaño (si aplica) y, por cada plataforma que
 * vende ese tamaño, su precio — más pickup, siempre la opción más barata.
 * Requiere $t, $lang. El contenido dinámico (tamaños, precios, plataformas)
 * lo llena js/order-modal.js a partir de data-order-payload de cada tarjeta.
 */
?>
<div class="order-modal" id="orderModal" hidden
     data-i18n-pickup="<?= htmlspecialchars(t($t, 'menu.order_pickup')) ?>"
     data-i18n-pickup-hint="<?= htmlspecialchars(t($t, 'menu.order_pickup_hint')) ?>"
     data-i18n-estimate="<?= htmlspecialchars(t($t, 'menu.order_estimate_tag')) ?>"
     data-i18n-pickup-only="<?= htmlspecialchars(t($t, 'menu.order_pickup_only')) ?>">
  <div class="order-modal__backdrop" data-order-close></div>
  <div class="order-modal__panel" role="dialog" aria-modal="true" aria-labelledby="orderModalTitle">
    <button type="button" class="order-modal__close" data-order-close aria-label="<?= htmlspecialchars(t($t, 'menu.order_close')) ?>">&times;</button>

    <h2 class="order-modal__title" id="orderModalTitle"><?= htmlspecialchars(t($t, 'menu.order_title')) ?></h2>
    <p class="order-modal__item" id="orderModalItem"></p>

    <div class="order-modal__size" id="orderModalSizeWrap" hidden>
      <label for="orderModalSize"><?= htmlspecialchars(t($t, 'menu.order_size_label')) ?></label>
      <select id="orderModalSize"></select>
    </div>

    <a href="tel:+17052227662" class="btn btn--primary order-modal__call">
      <?= htmlspecialchars(t($t, 'menu.order_call')) ?>
    </a>

    <p class="order-modal__or"><?= htmlspecialchars(t($t, 'menu.order_or')) ?></p>

    <ul class="order-modal__pricelist" id="orderModalPricelist"></ul>
  </div>
</div>
