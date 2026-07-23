<?php
/**
 * Header + navegación + selector de idioma + menú móvil.
 * Requiere $lang, $t, $seo (para resaltar el link activo).
 */

$navItems = [
    ['key' => 'home',    'path' => ''],
    ['key' => 'menu',    'path' => 'menu'],
    ['key' => 'about',   'path' => 'about'],
    ['key' => 'contact', 'path' => 'contact'],
];
$currentPath = $seo['path'] ?? '';
?>
<a href="#main" class="skip-link"><?= htmlspecialchars(t($t, 'common.skip_to_content')) ?></a>

<div class="site-topbar">
<?php include ROOT_PATH . '/components/promo-banner.php'; ?>

<header class="site-header">
  <div class="site-header__inner u-container">
    <a href="<?= lang_url($lang) ?>" class="site-header__logo" aria-label="Pizzeria Roma — <?= htmlspecialchars(t($t, 'common.home')) ?>">
      <img src="/assets/images/logo/logocolor.svg" alt="Pizzeria Roma" width="189" height="65" loading="eager">
    </a>

    <nav class="site-nav u-visible-desktop" aria-label="<?= htmlspecialchars(t($t, 'nav.aria_label')) ?>">
      <ul class="site-nav__list">
        <?php foreach ($navItems as $item): ?>
        <li>
          <a href="<?= lang_url($lang, $item['path']) ?>"
             class="site-nav__link<?= $currentPath === $item['path'] ? ' site-nav__link--active' : '' ?>"
             <?= $currentPath === $item['path'] ? 'aria-current="page"' : '' ?>>
            <?= htmlspecialchars(t($t, 'nav.' . $item['key'])) ?>
          </a>
        </li>
        <?php endforeach; ?>
      </ul>
    </nav>

    <div class="site-header__actions">
      <a href="tel:+17052227662" class="site-header__phone u-visible-desktop"><?= htmlspecialchars(t($t, 'common.call_us')) ?>: 705-222-7662</a>

      <div class="lang-switch" role="group" aria-label="<?= htmlspecialchars(t($t, 'nav.language')) ?>">
        <a href="<?= lang_url('en', $currentPath) ?>"
           class="lang-switch__link<?= $lang === 'en' ? ' lang-switch__link--active' : '' ?>"
           hreflang="en" lang="en"<?= $lang === 'en' ? ' aria-current="true"' : '' ?>>EN</a>
        <span class="lang-switch__sep" aria-hidden="true">/</span>
        <a href="<?= lang_url('fr', $currentPath) ?>"
           class="lang-switch__link<?= $lang === 'fr' ? ' lang-switch__link--active' : '' ?>"
           hreflang="fr" lang="fr"<?= $lang === 'fr' ? ' aria-current="true"' : '' ?>>FR</a>
      </div>

      <button type="button" class="site-header__toggle u-visible-mobile" id="navToggle" aria-expanded="false" aria-controls="mobileNav">
        <span class="u-visually-hidden"><?= htmlspecialchars(t($t, 'nav.toggle_menu')) ?></span>
        <span class="site-header__toggle-bar"></span>
        <span class="site-header__toggle-bar"></span>
        <span class="site-header__toggle-bar"></span>
      </button>
    </div>
  </div>

  <nav id="mobileNav" class="mobile-nav" aria-label="<?= htmlspecialchars(t($t, 'nav.aria_label')) ?>" hidden>
    <ul class="mobile-nav__list">
      <?php foreach ($navItems as $item): ?>
      <li>
        <a href="<?= lang_url($lang, $item['path']) ?>" class="mobile-nav__link">
          <?= htmlspecialchars(t($t, 'nav.' . $item['key'])) ?>
        </a>
      </li>
      <?php endforeach; ?>
      <li><a href="tel:+17052227662" class="mobile-nav__link mobile-nav__link--phone">705-222-7662</a></li>
    </ul>
  </nav>
</header>
</div>
