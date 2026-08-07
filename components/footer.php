<?php
/**
 * Footer compartido: horario, contacto, delivery, copyright.
 * Requiere $lang, $t.
 */

$deliveryLinks = [
    ['name' => 'Uber Eats',        'url' => 'https://www.ubereats.com/ca/store/pizzeria-roma-paris-st/jkJ3fze_XeKlB_ypLqeW3A', 'logo' => '/assets/images/home/ubereats.svg'],
    ['name' => 'Skip The Dishes',  'url' => 'https://www.skipthedishes.com/pizzeria-roma-paris-st', 'logo' => '/assets/images/home/skipdishes.svg'],
    ['name' => 'DoorDash',         'url' => 'https://www.doordash.com/en-CA/store/pizzeria-roma-greater-sudbury-24665969/20453969/', 'logo' => '/assets/images/home/doordash.svg'],
    ['name' => 'indiEats',         'url' => 'https://takeout.indieats.ca/restaurant/pizza%20roma%201894%20(south%20end)', 'logo' => '/assets/images/home/indieats.svg'],
];

$socialLinks = [
    [
        'name' => 'Facebook',
        'url'  => 'https://www.facebook.com/www.pizzeriaroma.ca/?locale=es_LA',
        'icon' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M22 12.06C22 6.5 17.52 2 12 2S2 6.5 2 12.06c0 5 3.66 9.15 8.44 9.94v-7.03H7.9v-2.91h2.54V9.85c0-2.5 1.49-3.89 3.77-3.89 1.09 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56v1.88h2.78l-.44 2.91h-2.34V22c4.78-.79 8.44-4.94 8.44-9.94z"/></svg>',
    ],
    [
        'name' => 'Instagram',
        'url'  => 'https://www.instagram.com/pizzeriaroma1894/?hl=es',
        'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="2.5" y="2.5" width="19" height="19" rx="5"/><circle cx="12" cy="12" r="4.2"/><circle cx="17.6" cy="6.4" r="1.1" fill="currentColor" stroke="none"/></svg>',
    ],
];
?>
<footer class="site-footer">
  <div class="u-container site-footer__grid">
    <div class="site-footer__brand">
      <img src="/assets/images/logo/logocolor.svg" alt="Pizzeria Roma" width="216" height="76" loading="lazy">
      <p class="site-footer__tagline"><?= htmlspecialchars(t($t, 'footer.tagline')) ?></p>
      <ul class="site-footer__social">
        <?php foreach ($socialLinks as $s): ?>
        <li>
          <a href="<?= htmlspecialchars($s['url']) ?>" target="_blank" rel="noopener noreferrer" class="site-footer__social-link" aria-label="<?= htmlspecialchars($s['name']) ?>">
            <?= $s['icon'] ?>
          </a>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>

    <div class="site-footer__col">
      <h2 class="site-footer__heading"><?= htmlspecialchars(t($t, 'footer.hours_title')) ?></h2>
      <ul class="site-footer__hours">
        <li><?= htmlspecialchars(t($t, 'footer.hours_mon_thu')) ?></li>
        <li><?= htmlspecialchars(t($t, 'footer.hours_fri_sat')) ?></li>
        <li><?= htmlspecialchars(t($t, 'footer.hours_sun')) ?></li>
      </ul>
    </div>

    <div class="site-footer__col">
      <h2 class="site-footer__heading"><?= htmlspecialchars(t($t, 'footer.contact_title')) ?></h2>
      <address class="site-footer__address">
        <a href="tel:+17052227662">705-222-ROMA</a>
        <p><?= htmlspecialchars(t($t, 'footer.address')) ?></p>
      </address>
    </div>

    <div class="site-footer__col">
      <h2 class="site-footer__heading"><?= htmlspecialchars(t($t, 'footer.delivery_title')) ?></h2>
      <ul class="site-footer__delivery">
        <?php foreach ($deliveryLinks as $d): ?>
        <li>
          <a href="<?= htmlspecialchars($d['url']) ?>" target="_blank" rel="noopener noreferrer" class="site-footer__delivery-link" aria-label="<?= htmlspecialchars($d['name']) ?>">
            <img src="<?= htmlspecialchars($d['logo']) ?>" alt="<?= htmlspecialchars($d['name']) ?>" width="120" height="32" loading="lazy">
          </a>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>

  <div class="site-footer__bottom u-container">
    <p>&copy; <?= date('Y') ?> Pizzeria Roma. <?= htmlspecialchars(t($t, 'footer.rights')) ?></p>
    <a href="https://graphiccodelab.com" target="_blank" rel="noopener noreferrer">Website created and managed by graphiccodelab.com</a>
  </div>
</footer>
