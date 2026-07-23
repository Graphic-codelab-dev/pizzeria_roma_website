<?php

require_once __DIR__ . '/includes/auth_guard.php';
require_once __DIR__ . '/includes/helpers.php';

$pdo = require ROOT_PATH . '/config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'toggle_active') {
    csrf_require_or_die();
    $id = (int) ($_POST['id'] ?? 0);
    $pdo->prepare('UPDATE categories SET is_active = NOT is_active WHERE id = :id')->execute(['id' => $id]);
    admin_flash_set('Category status updated.');
    admin_redirect('/admin/categorias.php');
}

$categories = $pdo->query('SELECT * FROM categories ORDER BY display_order ASC')->fetchAll();

$pageTitle = 'Categories';
include __DIR__ . '/includes/layout-header.php';
?>
<div class="admin-page-head">
  <h1>Categories</h1>
  <a class="btn btn--primary" href="/admin/categoria-edit.php">+ New category</a>
</div>

<div class="admin-table-wrap">
<table class="admin-table">
  <thead>
    <tr><th>Name (EN)</th><th>Name (FR)</th><th>Order</th><th>Status</th><th>Actions</th></tr>
  </thead>
  <tbody>
    <?php foreach ($categories as $cat): ?>
    <tr>
      <td><?= htmlspecialchars($cat['name_en']) ?></td>
      <td><?= htmlspecialchars($cat['name_fr']) ?></td>
      <td><?= (int) $cat['display_order'] ?></td>
      <td>
        <span class="admin-badge admin-badge--<?= $cat['is_active'] ? 'active' : 'inactive' ?>">
          <?= $cat['is_active'] ? 'Active' : 'Inactive' ?>
        </span>
      </td>
      <td class="admin-table__actions">
        <a class="btn btn--sm btn--outline" href="/admin/categoria-edit.php?id=<?= (int) $cat['id'] ?>">Edit</a>
        <form method="post" class="admin-inline-form">
          <?= csrf_field() ?>
          <input type="hidden" name="action" value="toggle_active">
          <input type="hidden" name="id" value="<?= (int) $cat['id'] ?>">
          <button type="submit" class="btn btn--sm btn--dark"><?= $cat['is_active'] ? 'Deactivate' : 'Activate' ?></button>
        </form>
        <form method="post" action="/admin/categoria-delete.php" class="admin-inline-form" data-confirm="Delete this category? It must have no products assigned first.">
          <?= csrf_field() ?>
          <input type="hidden" name="id" value="<?= (int) $cat['id'] ?>">
          <button type="submit" class="btn btn--sm btn--outline admin-btn-danger">Delete</button>
        </form>
      </td>
    </tr>
    <?php endforeach; ?>
    <?php if (!$categories): ?>
    <tr><td colspan="5">No categories yet.</td></tr>
    <?php endif; ?>
  </tbody>
</table>
</div>

<?php include __DIR__ . '/includes/layout-footer.php'; ?>
