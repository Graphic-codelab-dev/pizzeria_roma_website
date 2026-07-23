<?php
$deliveryPlatforms = require ROOT_PATH . '/config/delivery-platforms.php';
?>
<section class="delivery u-section u-section--tight" id="delivery" data-reveal>
  <div class="u-container delivery__inner">
    <div class="delivery__content">
      <h2><?= htmlspecialchars(t($t, 'home.delivery_title')) ?></h2>
      <div class="delivery__logos">
        <?php foreach ($deliveryPlatforms as $d): ?>
        <a href="<?= htmlspecialchars($d['url']) ?>" class="delivery__logo-link" target="_blank" rel="noopener noreferrer" aria-label="<?= htmlspecialchars($d['name']) ?>">
          <img src="<?= htmlspecialchars($d['logo']) ?>" alt="<?= htmlspecialchars($d['name']) ?>" width="160" height="48" loading="lazy">
        </a>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="delivery__media">
      <!-- FOTO: pizza lista para entrega / repartidor. Reemplazar por imagen real del cliente (assets/images/home/). Mockup temporal mientras no hay foto. -->
      <img class="delivery__photo" src="/assets/images/home/delivery.webp"
           alt="<?= htmlspecialchars(t($t, 'home.delivery_title')) ?>"
           width="900" height="1100" loading="lazy" decoding="async">
    </div>
  </div>
</section>
