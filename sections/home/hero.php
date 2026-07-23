<?php
/** Requiere $lang, $t (config/bootstrap.php ya cargado por la página). */
?>
<section class="home-hero on-dark">
  <video class="home-hero__media" autoplay muted loop playsinline preload="auto" aria-hidden="true">
    <source src="/assets/videos/video_bg_hero.mp4" type="video/mp4">
  </video>
  <div class="home-hero__scrim" aria-hidden="true"></div>
  <div class="u-container home-hero__grid">
    <div class="home-hero__content">
      <span class="u-eyebrow u-eyebrow--on-dark"><?= htmlspecialchars(t($t, 'home.hero_eyebrow')) ?></span>
      <h1 class="home-hero__title"><?= htmlspecialchars(t($t, 'home.hero_title')) ?></h1>
      <p class="home-hero__subtitle"><?= htmlspecialchars(t($t, 'home.hero_subtitle')) ?></p>
      <div class="home-hero__actions">
        <a href="<?= lang_url($lang, 'menu') ?>" class="btn btn--primary"><?= htmlspecialchars(t($t, 'home.hero_cta_menu')) ?></a>
        <a href="#delivery" class="btn btn--outline-light"><?= htmlspecialchars(t($t, 'home.hero_cta_order')) ?></a>
      </div>
    </div>
    <div class="home-hero__visual">
      <img class="home-hero__photo" src="/assets/images/home/foto_hero.webp"
           alt="<?= htmlspecialchars(t($t, 'home.hero_title')) ?>"
           width="1604" height="1798" loading="eager" fetchpriority="high" decoding="async">
    </div>
  </div>
</section> 
