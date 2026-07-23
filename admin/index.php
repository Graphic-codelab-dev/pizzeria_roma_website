<?php

require_once __DIR__ . '/includes/auth_guard.php';
require_once __DIR__ . '/includes/helpers.php';

$pdo = require ROOT_PATH . '/config/db.php';

$productCount       = (int) $pdo->query('SELECT COUNT(*) FROM products')->fetchColumn();
$activeProductCount  = (int) $pdo->query('SELECT COUNT(*) FROM products WHERE is_active = 1')->fetchColumn();
$categoryCount       = (int) $pdo->query('SELECT COUNT(*) FROM categories')->fetchColumn();
$promoActive         = (bool) $pdo->query('SELECT COUNT(*) FROM promotions WHERE is_active = 1')->fetchColumn();

$pageTitle = 'Dashboard';
include __DIR__ . '/includes/layout-header.php';
?>
<h1>Dashboard</h1>
<p class="u-text-muted">Welcome back, <?= htmlspecialchars($_SESSION['admin_email'] ?? '') ?>.</p>

<div class="admin-stats">
  <div class="admin-stat-card">
    <span class="admin-stat-card__value"><?= $activeProductCount ?> / <?= $productCount ?></span>
    <span class="admin-stat-card__label">Active products</span>
  </div>
  <div class="admin-stat-card">
    <span class="admin-stat-card__value"><?= $categoryCount ?></span>
    <span class="admin-stat-card__label">Categories</span>
  </div>
  <div class="admin-stat-card">
    <span class="admin-stat-card__value"><?= $promoActive ? 'On' : 'Off' ?></span>
    <span class="admin-stat-card__label">Promotion banner</span>
  </div>
</div>

<div class="admin-quick-links">
  <a class="btn btn--primary" href="/admin/producto-edit.php">+ New product</a>
  <a class="btn btn--outline" href="/admin/categorias.php">Manage categories</a>
  <a class="btn btn--outline" href="/admin/promociones.php">Edit promotion</a>
</div>

<?php include __DIR__ . '/includes/layout-footer.php'; ?>
