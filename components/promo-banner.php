<?php
/**
 * Banner de promoción activa. Lee de la BD (editable desde
 * /admin/promociones); si la BD no está disponible o no hay promo
 * activa, degrada mostrando el texto por defecto de las traducciones.
 */

$promoText   = t($t, 'promo.default_text');
$promoActive = true;

try {
    $pdo   = require ROOT_PATH . '/config/db.php';
    $today = date('Y-m-d');
    $stmt  = $pdo->prepare(
        'SELECT text_en, text_fr FROM promotions
         WHERE is_active = 1
           AND (start_date IS NULL OR start_date <= :today)
           AND (end_date IS NULL OR end_date >= :today)
         ORDER BY id DESC LIMIT 1'
    );
    $stmt->execute(['today' => $today]);
    $promo = $stmt->fetch();

    if ($promo) {
        $promoText = $lang === 'fr' ? $promo['text_fr'] : $promo['text_en'];
    } else {
        $promoActive = false;
    }
} catch (Throwable $e) {
    // BD no disponible en este entorno: se mantiene el texto por defecto.
}

if ($promoActive && trim($promoText) !== ''): ?>
<div class="promo-banner" role="note">
  <p class="promo-banner__text u-container">
    <span class="promo-banner__icon" aria-hidden="true">🔥</span>
    <?= htmlspecialchars($promoText) ?>
  </p>
</div>
<?php endif; ?>
