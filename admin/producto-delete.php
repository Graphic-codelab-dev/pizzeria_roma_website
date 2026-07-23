<?php

require_once __DIR__ . '/includes/auth_guard.php';
require_once __DIR__ . '/includes/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    admin_redirect('/admin/productos.php');
}

csrf_require_or_die();

$pdo = require ROOT_PATH . '/config/db.php';
$id  = (int) ($_POST['id'] ?? 0);

if ($id) {
    $pdo->prepare('DELETE FROM products WHERE id = :id')->execute(['id' => $id]);
    admin_flash_set('Product deleted.');
}

admin_redirect('/admin/productos.php');
