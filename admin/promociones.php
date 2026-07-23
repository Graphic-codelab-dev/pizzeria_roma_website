<?php

require_once __DIR__ . '/includes/auth_guard.php';
require_once __DIR__ . '/includes/helpers.php';

$pdo = require ROOT_PATH . '/config/db.php';

$promo = $pdo->query('SELECT * FROM promotions ORDER BY id DESC LIMIT 1')->fetch();
if (!$promo) {
    $promo = ['id' => 0, 'text_en' => '', 'text_fr' => '', 'is_active' => 0, 'start_date' => '', 'end_date' => ''];
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_require_or_die();

    $textEn    = trim((string) ($_POST['text_en'] ?? ''));
    $textFr    = trim((string) ($_POST['text_fr'] ?? ''));
    $isActive  = isset($_POST['is_active']) ? 1 : 0;
    $startDate = trim((string) ($_POST['start_date'] ?? '')) ?: null;
    $endDate   = trim((string) ($_POST['end_date'] ?? '')) ?: null;

    if ($textEn === '' || $textFr === '') {
        $errors[] = 'Banner text (English and French) is required.';
    }
    if ($startDate && $endDate && $startDate > $endDate) {
        $errors[] = 'The start date must be before the end date.';
    }

    if (!$errors) {
        $params = [
            'text_en'    => $textEn,
            'text_fr'    => $textFr,
            'is_active'  => $isActive,
            'start_date' => $startDate,
            'end_date'   => $endDate,
        ];

        if ($promo['id']) {
            $stmt = $pdo->prepare(
                'UPDATE promotions SET text_en=:text_en, text_fr=:text_fr, is_active=:is_active,
                 start_date=:start_date, end_date=:end_date WHERE id=:id'
            );
            $params['id'] = $promo['id'];
        } else {
            $stmt = $pdo->prepare(
                'INSERT INTO promotions (text_en, text_fr, is_active, start_date, end_date)
                 VALUES (:text_en, :text_fr, :is_active, :start_date, :end_date)'
            );
        }

        $stmt->execute($params);

        admin_flash_set('Promotion updated.');
        admin_redirect('/admin/promociones.php');
    }

    $promo = array_merge($promo, [
        'text_en' => $textEn, 'text_fr' => $textFr, 'is_active' => $isActive,
        'start_date' => $startDate, 'end_date' => $endDate,
    ]);
}

$pageTitle = 'Promotion';
include __DIR__ . '/includes/layout-header.php';
?>
<h1>Promotion Banner</h1>
<p class="u-text-muted">This text appears in the banner at the top of every page on the website.</p>

<?php if ($errors): ?>
<div class="admin-flash admin-flash--error">
  <ul><?php foreach ($errors as $err): ?><li><?= htmlspecialchars($err) ?></li><?php endforeach; ?></ul>
</div>
<?php endif; ?>

<form method="post" class="admin-form">
  <?= csrf_field() ?>

  <div class="admin-form__field">
    <label for="text_en">Banner text (English)</label>
    <textarea id="text_en" name="text_en" rows="2" required><?= htmlspecialchars((string) $promo['text_en']) ?></textarea>
  </div>

  <div class="admin-form__field">
    <label for="text_fr">Banner text (French)</label>
    <textarea id="text_fr" name="text_fr" rows="2" required><?= htmlspecialchars((string) $promo['text_fr']) ?></textarea>
  </div>

  <div class="admin-form__row">
    <div class="admin-form__field">
      <label for="start_date">Start date (optional)</label>
      <input id="start_date" name="start_date" type="date" value="<?= htmlspecialchars((string) $promo['start_date']) ?>">
    </div>
    <div class="admin-form__field">
      <label for="end_date">End date (optional)</label>
      <input id="end_date" name="end_date" type="date" value="<?= htmlspecialchars((string) $promo['end_date']) ?>">
    </div>
  </div>

  <div class="admin-form__row admin-form__row--checkboxes">
    <label class="admin-checkbox">
      <input type="checkbox" name="is_active" value="1" <?= $promo['is_active'] ? 'checked' : '' ?>>
      Show banner on the website
    </label>
  </div>

  <div class="admin-form__actions">
    <button type="submit" class="btn btn--primary">Save promotion</button>
  </div>
</form>

<?php include __DIR__ . '/includes/layout-footer.php'; ?>
