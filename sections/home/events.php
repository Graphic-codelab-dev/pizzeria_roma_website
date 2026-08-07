<section class="events u-section" id="events" data-reveal>
  <div class="u-container events__inner">
    <div class="events__media">
      <!-- FOTO: horno de leña portátil en un evento (boda, cumpleaños, evento corporativo). Reemplazar por imagen real del cliente (assets/images/home/). Mockup temporal mientras no hay foto. -->
      <img class="events__photo" src="/assets/images/home/events.webp"
           alt="<?= htmlspecialchars(t($t, 'home.events_title')) ?>"
           width="900" height="1100" loading="lazy" decoding="async">
    </div>
    <div class="events__content">
      <span class="u-eyebrow"><?= htmlspecialchars(t($t, 'home.events_eyebrow')) ?></span>
      <h2><?= htmlspecialchars(t($t, 'home.events_title')) ?></h2>
      <span class="u-divider-accent" aria-hidden="true"></span>
      <p class="events__body"><?= htmlspecialchars(t($t, 'home.events_body')) ?></p>
      <a href="<?= lang_url($lang, 'contact') ?>" class="btn btn--primary"><?= htmlspecialchars(t($t, 'home.events_cta')) ?></a>
      <a href="tel:+17055617166" class="events__phone"><?= htmlspecialchars(t($t, 'home.events_call')) ?>: 705-561-7166</a>
    </div>
  </div>
</section>
