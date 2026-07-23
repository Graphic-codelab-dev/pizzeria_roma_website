<?php
/**
 * Requiere $faqItems (array de ['q' => ..., 'a' => ...]), definido en
 * pages/home.php antes del include para poder reutilizarlo también en
 * el schema.org FAQPage de $seo['schema'].
 */
?>
<section class="home-faq u-section" data-reveal>
  <div class="u-container home-faq__inner">
    <div class="home-faq__content">
      <div class="home-faq__head" data-reveal="fade">
        <span class="u-eyebrow"><?= htmlspecialchars(t($t, 'home.faq_eyebrow')) ?></span>
        <h2><?= htmlspecialchars(t($t, 'home.faq_title')) ?></h2>
      </div>

      <div class="home-faq__list">
        <?php foreach ($faqItems as $item): ?>
        <details class="home-faq__item">
          <summary class="home-faq__question"><?= htmlspecialchars($item['q']) ?></summary>
          <p class="home-faq__answer"><?= htmlspecialchars($item['a']) ?></p>
        </details>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="home-faq__media">
      <!-- FOTO: interior del restaurante / pizza recién horneada. Reemplazar por imagen real del cliente (assets/images/home/). Mockup temporal mientras no hay foto. -->
      <img class="home-faq__photo" src="/assets/images/home/grandpa.webp"
           alt="<?= htmlspecialchars(t($t, 'home.faq_title')) ?>"
           width="900" height="1100" loading="lazy" decoding="async">
    </div>
  </div>
</section>
