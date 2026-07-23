<section class="about-story u-section" data-reveal>
  <div class="u-container about-story__inner">
    <!-- FOTO: dueño / restaurante. Reemplazar por imagen real del cliente (assets/images/about/). -->
    <div class="about-story__media">
      <img class="about-story__photo" src="/assets/images/about/robert.webp"
           alt="<?= htmlspecialchars(t($t, 'about.hero_title')) ?>"
           width="900" height="1125" loading="lazy" decoding="async">
    </div>
    <div class="about-story__body">
      <span class="u-eyebrow"><?= htmlspecialchars(t($t, 'about.story_eyebrow')) ?></span>
      <h2><?= htmlspecialchars(t($t, 'about.story_title')) ?></h2>
      <p><?= htmlspecialchars(t($t, 'about.intro_body_1')) ?></p>
      <p><?= htmlspecialchars(t($t, 'about.intro_body_2')) ?></p>
      <p><?= htmlspecialchars(t($t, 'about.intro_body_3')) ?></p>
    </div>
  </div>
</section>
