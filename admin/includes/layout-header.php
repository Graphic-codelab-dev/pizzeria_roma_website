<?php
/** Requiere $pageTitle. auth_guard.php ya debe haberse incluido. */
$flash = admin_flash_get();
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($pageTitle ?? 'Admin') ?> — Pizzeria Roma Admin</title>
<meta name="robots" content="noindex, nofollow">
<link rel="stylesheet" href="/css/tokens.css?v=<?= filemtime(ROOT_PATH . '/css/tokens.css') ?>">
<link rel="stylesheet" href="/css/base.css?v=<?= filemtime(ROOT_PATH . '/css/base.css') ?>">
<link rel="stylesheet" href="/css/utilities.css?v=<?= filemtime(ROOT_PATH . '/css/utilities.css') ?>">
<link rel="stylesheet" href="/css/admin.css?v=<?= filemtime(ROOT_PATH . '/css/admin.css') ?>">
</head>
<body class="admin-body">
<div class="admin-shell">

  <header class="admin-topbar">
    <a href="/admin/index.php" class="admin-topbar__brand">Pizzeria Roma <span>Admin</span></a>
    <button type="button" class="admin-topbar__toggle" id="adminNavToggle" aria-expanded="false" aria-controls="adminNav">
      <span class="u-visually-hidden">Toggle menu</span>
      ☰
    </button>
  </header>

  <nav class="admin-nav" id="adminNav">
    <a href="/admin/index.php" class="admin-nav__link<?= admin_nav_active('index.php') ?>">Dashboard</a>
    <a href="/admin/productos.php" class="admin-nav__link<?= admin_nav_active('productos.php', 'producto-edit.php') ?>">Products</a>
    <a href="/admin/categorias.php" class="admin-nav__link<?= admin_nav_active('categorias.php', 'categoria-edit.php') ?>">Categories</a>
    <a href="/admin/promociones.php" class="admin-nav__link<?= admin_nav_active('promociones.php') ?>">Promotion</a>
    <a href="/admin/logout.php" class="admin-nav__link admin-nav__link--logout">Log out</a>
  </nav>

  <main class="admin-main">
    <?php if ($flash): ?>
    <div class="admin-flash admin-flash--<?= htmlspecialchars($flash['type']) ?>"><?= htmlspecialchars($flash['message']) ?></div>
    <?php endif; ?>
