<?php
/**
 * Crea el primer usuario admin. Se desactiva automáticamente en cuanto
 * exista al menos un admin_user — solo funciona una vez. Después de
 * usarla, se recomienda eliminar este archivo del servidor.
 */

require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/csrf.php';

$pdo = require ROOT_PATH . '/config/db.php';

$existingCount = (int) $pdo->query('SELECT COUNT(*) FROM admin_users')->fetchColumn();

$error   = null;
$success = false;

if ($existingCount > 0) {
    $error = 'An admin user already exists. This setup page is disabled for security. Delete admin/setup.php from the server.';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_require_or_die();

    $email            = trim((string) ($_POST['email'] ?? ''));
    $password         = (string) ($_POST['password'] ?? '');
    $passwordConfirm  = (string) ($_POST['password_confirm'] ?? '');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($password) < 10) {
        $error = 'Password must be at least 10 characters.';
    } elseif ($password !== $passwordConfirm) {
        $error = 'Passwords do not match.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO admin_users (email, password_hash) VALUES (:email, :hash)');
        $stmt->execute([
            'email' => $email,
            'hash'  => password_hash($password, PASSWORD_DEFAULT),
        ]);
        $success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin Setup — Pizzeria Roma</title>
<meta name="robots" content="noindex, nofollow">
<link rel="stylesheet" href="/css/tokens.css">
<link rel="stylesheet" href="/css/base.css">
<link rel="stylesheet" href="/css/admin.css">
</head>
<body class="admin-login-body">
  <main class="admin-login">
    <?php if ($success): ?>
    <div class="admin-login__form">
      <h1 class="admin-login__title">Pizzeria Roma <span>Admin</span></h1>
      <div class="admin-flash admin-flash--success">Admin account created. You can now <a href="/admin/login.php">log in</a>.</div>
    </div>
    <?php else: ?>
    <form method="post" class="admin-login__form" novalidate>
      <h1 class="admin-login__title">Create Admin Account</h1>
      <p class="u-text-muted">One-time setup — this only works if no admin account exists yet.</p>

      <?php if ($error): ?>
      <div class="admin-flash admin-flash--error"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <?php if ($existingCount === 0): ?>
      <?= csrf_field() ?>
      <div class="admin-form__field">
        <label for="email">Email</label>
        <input id="email" name="email" type="email" required autocomplete="username">
      </div>
      <div class="admin-form__field">
        <label for="password">Password (min. 10 characters)</label>
        <input id="password" name="password" type="password" required minlength="10" autocomplete="new-password">
      </div>
      <div class="admin-form__field">
        <label for="password_confirm">Confirm password</label>
        <input id="password_confirm" name="password_confirm" type="password" required minlength="10" autocomplete="new-password">
      </div>
      <button type="submit" class="btn btn--primary admin-login__submit">Create account</button>
      <?php endif; ?>
    </form>
    <?php endif; ?>
  </main>
</body>
</html>
