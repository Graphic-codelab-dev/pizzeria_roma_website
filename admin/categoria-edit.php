<?php

require_once __DIR__ . '/includes/auth_guard.php';
require_once __DIR__ . '/includes/helpers.php';

$pdo = require ROOT_PATH . '/config/db.php';
$id  = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$category = ['id' => 0, 'name_en' => '', 'name_fr' => '', 'slug' => '', 'display_order' => 0, 'is_active' => 1];

if ($id) {
    $stmt = $pdo->prepare('SELECT * FROM categories WHERE id = :id');
    $stmt->execute(['id' => $id]);
    $existing = $stmt->fetch();
    if (!$existing) {
        admin_flash_set('Category not found.', 'error');
        admin_redirect('/admin/categorias.php');
    }
    $category = $existing;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_require_or_die();

    $category['name_en']       = trim((string) ($_POST['name_en'] ?? ''));
    $category['name_fr']       = trim((string) ($_POST['name_fr'] ?? ''));
    $category['display_order'] = (int) ($_POST['display_order'] ?? 0);
    $category['is_active']     = isset($_POST['is_active']) ? 1 : 0;

    if ($category['name_en'] === '' || $category['name_fr'] === '') {
        $errors[] = 'Name (English and French) is required.';
    }

    if (!$errors) {
        $slugBase = strtolower(trim((string) preg_replace('/[^a-z0-9]+/i', '-', $category['name_en']), '-'));
        $slug     = $slugBase !== '' ? $slugBase : 'category';

        // Garantiza un slug único (excluyendo la propia categoría en edición).
        $suffix = 1;
        while (true) {
            $check = $pdo->prepare('SELECT COUNT(*) FROM categories WHERE slug = :slug AND id != :id');
            $check->execute(['slug' => $slug, 'id' => $id ?: 0]);
            if ((int) $check->fetchColumn() === 0) {
                break;
            }
            $slug = $slugBase . '-' . (++$suffix);
        }
        $category['slug'] = $slug;

        $params = [
            'name_en'       => $category['name_en'],
            'name_fr'       => $category['name_fr'],
            'slug'          => $category['slug'],
            'display_order' => $category['display_order'],
            'is_active'     => $category['is_active'],
        ];

        if ($id) {
            $stmt = $pdo->prepare(
                'UPDATE categories SET name_en=:name_en, name_fr=:name_fr, slug=:slug,
                 display_order=:display_order, is_active=:is_active WHERE id=:id'
            );
            $params['id'] = $id;
        } else {
            $stmt = $pdo->prepare(
                'INSERT INTO categories (name_en, name_fr, slug, display_order, is_active)
                 VALUES (:name_en, :name_fr, :slug, :display_order, :is_active)'
            );
        }

        $stmt->execute($params);

        admin_flash_set($id ? 'Category updated.' : 'Category created.');
        admin_redirect('/admin/categorias.php');
    }
}

$pageTitle = $id ? 'Edit Category' : 'New Category';
include __DIR__ . '/includes/layout-header.php';
?>
<h1><?= htmlspecialchars($pageTitle) ?></h1>

<?php if ($errors): ?>
<div class="admin-flash admin-flash--error">
  <ul><?php foreach ($errors as $err): ?><li><?= htmlspecialchars($err) ?></li><?php endforeach; ?></ul>
</div>
<?php endif; ?>

<form method="post" class="admin-form">
  <?= csrf_field() ?>

  <div class="admin-form__row">
    <div class="admin-form__field">
      <label for="name_en">Name (English)</label>
      <input id="name_en" name="name_en" type="text" required value="<?= htmlspecialchars($category['name_en']) ?>">
    </div>
    <div class="admin-form__field">
      <label for="name_fr">Name (French)</label>
      <input id="name_fr" name="name_fr" type="text" required value="<?= htmlspecialchars($category['name_fr']) ?>">
    </div>
  </div>

  <div class="admin-form__row">
    <div class="admin-form__field">
      <label for="display_order">Display order</label>
      <input id="display_order" name="display_order" type="number" min="0" value="<?= (int) $category['display_order'] ?>">
    </div>
  </div>

  <div class="admin-form__row admin-form__row--checkboxes">
    <label class="admin-checkbox">
      <input type="checkbox" name="is_active" value="1" <?= $category['is_active'] ? 'checked' : '' ?>>
      Active (visible on site)
    </label>
  </div>

  <div class="admin-form__actions">
    <button type="submit" class="btn btn--primary">Save category</button>
    <a href="/admin/categorias.php" class="btn btn--outline">Cancel</a>
  </div>
</form>

<?php include __DIR__ . '/includes/layout-footer.php'; ?>
