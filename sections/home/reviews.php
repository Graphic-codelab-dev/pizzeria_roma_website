<?php
// TODO: reemplazar "#" con la URL real del perfil de Google Business y TripAdvisor.
?>
<section class="reviews u-section u-section--tight" data-reveal>
  <div class="u-container u-text-center">
    <span class="u-eyebrow"><?= htmlspecialchars(t($t, 'home.reviews_eyebrow')) ?></span>
    <h2><?= htmlspecialchars(t($t, 'home.reviews_title')) ?></h2>

    <div class="reviews__grid">
      <a class="reviews__card" href="https://www.google.com/search?q=pizzeria+roma+reviews&oq=pizzeria+roma+reviews&sourceid=chrome&ie=UTF-8#sv=CAESzQEKuQEStgEKd0FKaVQ0dEk2blgzbUp3Ul82VmU3TmxEcnh3U19DRnNjeG14VjBRN1NHQzNaRE1SYjh6T29aNTc0aVNWTGdaZmpiaDBQTmJkTVk1VHpvZzdleVphSUswQ2IxSGNfQjZLVTlvWFpDVFpEcW1mSnBUVmZjMHJZblhvEhdaUUZoYW9pQ01lT3d3OGNQbXFYYndROBoiQURzcjlmUS0zeUpfLUhhcGpZU21mNW9xZFA1SFl6cUM2URIEODA1MRoBMyoAMAA4AUAAGAAg_vKceUoCEAI" target="_blank" rel="noopener noreferrer">
        <img src="/assets/images/home/google.svg" alt="Google" width="32" height="32" loading="lazy">
        <p class="reviews__score">4.4 <span aria-hidden="true">★★★★☆</span></p>
        <p class="reviews__count">60 <?= htmlspecialchars(t($t, 'reviews.google_label')) ?></p>
      </a>
      <a class="reviews__card" href="https://www.tripadvisor.ca/Restaurant_Review-g155016-d23126910-Reviews-Pizzeria_Roma-Sudbury_Northeastern_Ontario_Ontario.html" target="_blank" rel="noopener noreferrer">
        <img src="/assets/images/home/tripadvisor.svg" alt="TripAdvisor" width="32" height="32" loading="lazy">
        <p class="reviews__score">4.7 <span aria-hidden="true">★★★★★</span></p>
        <p class="reviews__count">9 <?= htmlspecialchars(t($t, 'reviews.tripadvisor_label')) ?></p>
      </a>
    </div>
  </div>
</section>
