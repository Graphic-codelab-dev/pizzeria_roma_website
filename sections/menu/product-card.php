<?php
/** Requiere $p (producto, posiblemente fusionado con $p['order_payload']), $cat, $lang, $t. */
$name = $lang === 'fr' ? $p['name_fr'] : $p['name_en'];
$desc = $lang === 'fr' ? $p['description_fr'] : $p['description_en'];
$catName = $lang === 'fr' ? $cat['name_fr'] : $cat['name_en'];
$isFrom = !empty($p['price_is_from']);
$orderPayload = $p['order_payload'] ?? ['name' => $name, 'sizes' => []];
?>
<article class="menu-card"
         data-reveal="fade"
         role="button"
         tabindex="0"
         data-order-trigger
         data-order-payload='<?= htmlspecialchars(json_encode($orderPayload, JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8') ?>'
         data-category="cat-<?= (int) $cat['id'] ?>"
         data-name="<?= htmlspecialchars(mb_strtolower($name)) ?>"
         data-price="<?= (float) $p['price'] ?>"
         data-featured="<?= !empty($p['is_featured']) ? 1 : 0 ?>">
  <?php if (!empty($p['image_path'])): ?>
  <img class="menu-card__image" src="/<?= htmlspecialchars($p['image_path']) ?>"
       alt="<?= htmlspecialchars($name) ?>"
       loading="lazy" width="400" height="300">
  <?php endif; ?>
  <div class="menu-card__body">
    <span class="menu-card__category"><?= htmlspecialchars($catName) ?></span>
    <div class="menu-card__head">
      <h3 class="menu-card__name">
        <?= htmlspecialchars($name) ?>
        <?php if (!empty($p['is_featured'])): ?>
        <span class="u-badge-fire"><?= htmlspecialchars(t($t, 'menu.featured_badge')) ?></span>
        <?php endif; ?>
      </h3>
      <span class="menu-card__price">
        <?php if ($isFrom): ?><span class="menu-card__price-from"><?= htmlspecialchars(t($t, 'menu.price_from')) ?></span><?php endif; ?>
        $<?= number_format((float) $p['price'], 2) ?>
      </span>
    </div>
    <?php if ($desc): ?>
    <p class="menu-card__desc"><?= htmlspecialchars($desc) ?></p>
    <?php endif; ?>
  </div>
</article>
