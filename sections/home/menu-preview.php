<?php
/** Productos destacados (is_featured=1) leídos de la BD. Degrada sin romper la página si la BD no está disponible. */
$featuredProducts = [];
try {
    $pdo  = require ROOT_PATH . '/config/db.php';
    $stmt = $pdo->query(
        'SELECT * FROM products WHERE is_active = 1 AND is_featured = 1 ORDER BY display_order ASC LIMIT 4'
    );
    $featuredProducts = $stmt->fetchAll();
} catch (Throwable $e) {
    $featuredProducts = [];
}
?>
<section class="menu-preview u-section u-section--tight" id="menu-preview">
  <div class="u-container">
    <div class="menu-preview__head u-text-center" data-reveal="fade">
      <span class="u-eyebrow"><?= htmlspecialchars(t($t, 'home.menu_preview_eyebrow')) ?></span>
      <h2><?= htmlspecialchars(t($t, 'home.menu_preview_title')) ?></h2>
    </div>

    <?php if ($featuredProducts): ?>
    <div class="u-grid u-grid--4">
      <?php foreach ($featuredProducts as $p): ?>
      <article class="menu-card" data-reveal>
        <?php if (!empty($p['image_path'])): ?>
        <img class="menu-card__image" src="/<?= htmlspecialchars($p['image_path']) ?>"
             alt="<?= htmlspecialchars($lang === 'fr' ? $p['name_fr'] : $p['name_en']) ?>"
             loading="lazy" width="400" height="300">
        <?php endif; ?>
        <div class="menu-card__body">
          <div class="menu-card__head">
            <h3 class="menu-card__name"><?= htmlspecialchars($lang === 'fr' ? $p['name_fr'] : $p['name_en']) ?></h3>
            <span class="menu-card__price">$<?= number_format((float) $p['price'], 2) ?></span>
          </div>
          <?php $desc = $lang === 'fr' ? $p['description_fr'] : $p['description_en']; ?>
          <?php if ($desc): ?>
          <p class="menu-card__desc"><?= htmlspecialchars($desc) ?></p>
          <?php endif; ?>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <p class="menu-preview__cta" data-reveal="fade">
      <a href="<?= lang_url($lang, 'menu') ?>" class="btn btn--outline"><?= htmlspecialchars(t($t, 'home.menu_preview_cta')) ?></a>
    </p>
  </div>
</section>
