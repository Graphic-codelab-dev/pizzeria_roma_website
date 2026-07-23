<?php
/**
 * CTA de llamada — banner con imagen de fondo para invitar a llamar
 * directamente a la pizzeria. Componente reutilizable en cualquier página.
 * Requiere $lang, $t (config/bootstrap.php ya cargado por la página).
 */
?>
<section class="cta-call on-dark" data-reveal>
  <div class="cta-call__media" style="background-image: url('/assets/images/home/pizza-banner.webp');" aria-hidden="true"></div>
  <div class="cta-call__scrim" aria-hidden="true"></div>
  <div class="u-container cta-call__inner">
    <span class="u-eyebrow u-eyebrow--on-dark"><?= htmlspecialchars(t($t, 'cta_call.eyebrow')) ?></span>
    <h2 class="cta-call__title"><?= htmlspecialchars(t($t, 'cta_call.title')) ?></h2>
    <p class="cta-call__subtitle"><?= htmlspecialchars(t($t, 'cta_call.subtitle')) ?></p>
    <a href="tel:+17052227662" class="btn btn--primary cta-call__btn">
      <?= htmlspecialchars(t($t, 'cta_call.button')) ?>: 705-222-7662
    </a>
  </div>
</section>
