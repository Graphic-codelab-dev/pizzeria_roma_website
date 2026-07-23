<?php
/**
 * Popup de pedido: se abre al hacer click en un platillo del menú.
 * Ofrece llamar por teléfono o pedir por una de las plataformas de delivery.
 * Requiere $t, $lang y la constante ROOT_PATH.
 */
$deliveryPlatforms = require ROOT_PATH . '/config/delivery-platforms.php';
?>
<div class="order-modal" id="orderModal" hidden>
  <div class="order-modal__backdrop" data-order-close></div>
  <div class="order-modal__panel" role="dialog" aria-modal="true" aria-labelledby="orderModalTitle">
    <button type="button" class="order-modal__close" data-order-close aria-label="<?= htmlspecialchars(t($t, 'menu.order_close')) ?>">&times;</button>

    <h2 class="order-modal__title" id="orderModalTitle"><?= htmlspecialchars(t($t, 'menu.order_title')) ?></h2>
    <p class="order-modal__item" id="orderModalItem"></p>

    <a href="tel:+17052227662" class="btn btn--primary order-modal__call">
      <?= htmlspecialchars(t($t, 'menu.order_call')) ?>
    </a>

    <p class="order-modal__or"><?= htmlspecialchars(t($t, 'menu.order_or')) ?></p>

    <div class="order-modal__platforms">
      <?php foreach ($deliveryPlatforms as $d): ?>
      <a href="<?= htmlspecialchars($d['url']) ?>" class="order-modal__platform" target="_blank" rel="noopener noreferrer" aria-label="<?= htmlspecialchars($d['name']) ?>">
        <img src="<?= htmlspecialchars($d['logo']) ?>" alt="<?= htmlspecialchars($d['name']) ?>" width="140" height="40" loading="lazy">
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</div>
