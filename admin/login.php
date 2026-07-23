<?php

require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/csrf.php';

if (!empty($_SESSION['admin_id'])) {
    header('Location: /admin/index.php');
    exit;
}

const MAX_LOGIN_ATTEMPTS = 5;

$pdo   = require ROOT_PATH . '/config/db.php';
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_require_or_die();

    $email    = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    $stmt = $pdo->prepare('SELECT * FROM admin_users WHERE email = :email LIMIT 1');
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && !empty($user['locked_until']) && strtotime($user['locked_until']) > time()) {
        $error = 'Too many failed attempts. Please try again later.';
    } elseif ($user && password_verify($password, $user['password_hash'])) {
        $pdo->prepare('UPDATE admin_users SET failed_attempts = 0, locked_until = NULL, last_login = NOW() WHERE id = :id')
            ->execute(['id' => $user['id']]);

        session_regenerate_id(true);
        $_SESSION['admin_id']       = (int) $user['id'];
        $_SESSION['admin_email']    = $user['email'];
        $_SESSION['last_activity']  = time();

        header('Location: /admin/index.php');
        exit;
    } else {
        if ($user) {
            $attempts    = (int) $user['failed_attempts'] + 1;
            $lockedUntil = null;
            if ($attempts >= MAX_LOGIN_ATTEMPTS) {
                $minutes     = min(60, 2 ** ($attempts - MAX_LOGIN_ATTEMPTS));
                $lockedUntil = date('Y-m-d H:i:s', time() + $minutes * 60);
            }
            $pdo->prepare('UPDATE admin_users SET failed_attempts = :a, locked_until = :l WHERE id = :id')
                ->execute(['a' => $attempts, 'l' => $lockedUntil, 'id' => $user['id']]);
        }
        $error = 'Invalid email or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Log in — Pizzeria Roma Admin</title>
<meta name="robots" content="noindex, nofollow">
<link rel="stylesheet" href="/css/tokens.css">
<link rel="stylesheet" href="/css/base.css">
<link rel="stylesheet" href="/css/admin.css">
</head>
<body class="admin-login-body">
  <main class="admin-login">
    <form method="post" class="admin-login__form" novalidate>
      <h1 class="admin-login__title">Pizzeria Roma <span>Admin</span></h1>

      <?php if ($error): ?>
      <div class="admin-flash admin-flash--error"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>
      <?php if (!empty($_GET['timeout'])): ?>
      <div class="admin-flash admin-flash--error">Your session expired. Please log in again.</div>
      <?php endif; ?>

      <?= csrf_field() ?>

      <div class="admin-form__field">
        <label for="email">Email</label>
        <input id="email" name="email" type="email" required autocomplete="username" autofocus>
      </div>

      <div class="admin-form__field">
        <label for="password">Password</label>
        <input id="password" name="password" type="password" required autocomplete="current-password">
      </div>

      <button type="submit" class="btn btn--primary admin-login__submit">Log in</button>
    </form>
  </main>
</body>
</html>
