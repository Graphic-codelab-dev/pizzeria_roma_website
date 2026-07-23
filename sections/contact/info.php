<section class="contact-info u-section u-section--tight" data-reveal>
  <div class="u-container contact-info__grid">
    <div class="contact-info__card">
      <h2><?= htmlspecialchars(t($t, 'contact.hours_title')) ?></h2>
      <ul>
        <li><?= htmlspecialchars(t($t, 'footer.hours_mon_thu')) ?></li>
        <li><?= htmlspecialchars(t($t, 'footer.hours_fri_sat')) ?></li>
        <li><?= htmlspecialchars(t($t, 'footer.hours_sun')) ?></li>
      </ul>
    </div>
    <div class="contact-info__card">
      <h2><?= htmlspecialchars(t($t, 'contact.info_title')) ?></h2>
      <a class="contact-info__phone" href="tel:+17052227662">705-222-7662</a>
      <p class="contact-info__address">
        <strong><?= htmlspecialchars(t($t, 'contact.address_title')) ?>:</strong>
        <?= htmlspecialchars(t($t, 'footer.address')) ?>
      </p>
    </div>
  </div>
</section>
