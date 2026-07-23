<?php

require_once __DIR__ . '/includes/auth_guard.php';
require_once __DIR__ . '/includes/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    admin_redirect('/admin/categorias.php');
}

csrf_require_or_die();

$pdo = require ROOT_PATH . '/config/db.php';
$id  = (int) ($_POST['id'] ?? 0);

if ($id) {
    $check = $pdo->prepare('SELECT COUNT(*) FROM products WHERE category_id = :id');
    $check->execute(['id' => $id]);
    $inUse = (int) $check->fetchColumn();

    if ($inUse > 0) {
        admin_flash_set('This category still has products assigned to it. Reassign or delete them first.', 'error');
    } else {
        $pdo->prepare('DELETE FROM categories WHERE id = :id')->execute(['id' => $id]);
        admin_flash_set('Category deleted.');
    }
}

admin_redirect('/admin/categorias.php');
