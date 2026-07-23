<?php

require_once __DIR__ . '/includes/auth_guard.php';
require_once __DIR__ . '/includes/helpers.php';

$pdo = require ROOT_PATH . '/config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'toggle_active') {
    csrf_require_or_die();
    $id = (int) ($_POST['id'] ?? 0);
    $pdo->prepare('UPDATE products SET is_active = NOT is_active WHERE id = :id')->execute(['id' => $id]);
    admin_flash_set('Product status updated.');
    admin_redirect('/admin/productos.php' . (!empty($_GET['category']) ? '?category=' . (int) $_GET['category'] : ''));
}

$categoryFilter = isset($_GET['category']) ? (int) $_GET['category'] : 0;
$categories     = $pdo->query('SELECT * FROM categories ORDER BY display_order ASC')->fetchAll();

$sql    = 'SELECT p.*, c.name_en AS category_name FROM products p JOIN categories c ON c.id = p.category_id';
$params = [];
if ($categoryFilter) {
    $sql .= ' WHERE p.category_id = :cat';
    $params['cat'] = $categoryFilter;
}
$sql .= ' ORDER BY p.display_order ASC';

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();

$pageTitle = 'Products';
include __DIR__ . '/includes/layout-header.php';
?>
<div class="admin-page-head">
  <h1>Products</h1>
  <a class="btn btn--primary" href="/admin/producto-edit.php">+ New product</a>
</div>

<form method="get" class="admin-filter">
  <label for="category">Filter by category</label>
  <select id="category" name="category" onchange="this.form.submit()">
    <option value="0">All categories</option>
    <?php foreach ($categories as $cat): ?>
    <option value="<?= (int) $cat['id'] ?>" <?= $categoryFilter === (int) $cat['id'] ? 'selected' : '' ?>>
      <?= htmlspecialchars($cat['name_en']) ?>
    </option>
    <?php endforeach; ?>
  </select>
</form>

<div class="admin-table-wrap">
<table class="admin-table">
  <thead>
    <tr><th>Photo</th><th>Name</th><th>Category</th><th>Price</th><th>Status</th><th>Actions</th></tr>
  </thead>
  <tbody>
    <?php foreach ($products as $p): ?>
    <tr>
      <td>
        <?php if ($p['image_path']): ?>
        <img src="/<?= htmlspecialchars($p['image_path']) ?>" alt="" width="56" height="56" class="admin-table__thumb">
        <?php endif; ?>
      </td>
      <td><?= htmlspecialchars($p['name_en']) ?></td>
      <td><?= htmlspecialchars($p['category_name']) ?></td>
      <td>$<?= number_format((float) $p['price'], 2) ?></td>
      <td>
        <span class="admin-badge admin-badge--<?= $p['is_active'] ? 'active' : 'inactive' ?>">
          <?= $p['is_active'] ? 'Active' : 'Inactive' ?>
        </span>
      </td>
      <td class="admin-table__actions">
        <a class="btn btn--sm btn--outline" href="/admin/producto-edit.php?id=<?= (int) $p['id'] ?>">Edit</a>
        <form method="post" class="admin-inline-form">
          <?= csrf_field() ?>
          <input type="hidden" name="action" value="toggle_active">
          <input type="hidden" name="id" value="<?= (int) $p['id'] ?>">
          <button type="submit" class="btn btn--sm btn--dark"><?= $p['is_active'] ? 'Deactivate' : 'Activate' ?></button>
        </form>
        <form method="post" action="/admin/producto-delete.php" class="admin-inline-form" data-confirm="Delete this product permanently? This cannot be undone.">
          <?= csrf_field() ?>
          <input type="hidden" name="id" value="<?= (int) $p['id'] ?>">
          <button type="submit" class="btn btn--sm btn--outline admin-btn-danger">Delete</button>
        </form>
      </td>
    </tr>
    <?php endforeach; ?>
    <?php if (!$products): ?>
    <tr><td colspan="6">No products found.</td></tr>
    <?php endif; ?>
  </tbody>
</table>
</div>

<?php include __DIR__ . '/includes/layout-footer.php'; ?>
