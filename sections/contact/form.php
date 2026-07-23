<section class="contact-form-section u-section u-section--tight" data-reveal>
  <div class="u-container contact-form-section__inner">
    <h2><?= htmlspecialchars(t($t, 'contact.form_title')) ?></h2>

    <form id="contactForm" class="contact-form" novalidate>
      <input type="hidden" name="access_key" value="<?= htmlspecialchars(env('WEB3FORMS_ACCESS_KEY', '')) ?>">
      <input type="hidden" name="subject" value="New message from Pizzeria Roma website">
      <input type="hidden" name="from_name" value="Pizzeria Roma Website">

      <!-- Honeypot anti-spam: debe permanecer vacío. Oculto visualmente en css/contact.css. -->
      <input type="text" name="botcheck" class="contact-form__honeypot" tabindex="-1" autocomplete="off" aria-hidden="true">

      <div class="contact-form__field">
        <label for="cf-name"><?= htmlspecialchars(t($t, 'contact.form_name')) ?></label>
        <input id="cf-name" name="name" type="text" required autocomplete="name">
      </div>

      <div class="contact-form__field">
        <label for="cf-email"><?= htmlspecialchars(t($t, 'contact.form_email')) ?></label>
        <input id="cf-email" name="email" type="email" required autocomplete="email">
      </div>

      <div class="contact-form__field">
        <label for="cf-phone"><?= htmlspecialchars(t($t, 'contact.form_phone')) ?></label>
        <input id="cf-phone" name="phone" type="tel" autocomplete="tel">
      </div>

      <div class="contact-form__field">
        <label for="cf-message"><?= htmlspecialchars(t($t, 'contact.form_message')) ?></label>
        <textarea id="cf-message" name="message" rows="5" required></textarea>
      </div>

      <button type="submit" class="btn btn--primary contact-form__submit">
        <?= htmlspecialchars(t($t, 'contact.form_submit')) ?>
      </button>

      <p class="contact-form__status" role="status" aria-live="polite"></p>
    </form>
  </div>
</section>

<script nonce="<?= htmlspecialchars($cspNonce) ?>">
  window.PR_I18N = {
    sending: <?= json_encode(t($t, 'contact.form_sending')) ?>,
    success: <?= json_encode(t($t, 'contact.form_success')) ?>,
    error: <?= json_encode(t($t, 'contact.form_error')) ?>,
    submitLabel: <?= json_encode(t($t, 'contact.form_submit')) ?>
  };
</script>
