<?php
/**
 * Debe ser el PRIMER include de toda página protegida del admin
 * (antes de cualquier salida), ya que puede emitir un redirect.
 */

require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/csrf.php';

const ADMIN_IDLE_TIMEOUT = 7200; // 2 horas

if (empty($_SESSION['admin_id'])) {
    header('Location: /admin/login.php');
    exit;
}

if (!empty($_SESSION['last_activity']) && (time() - (int) $_SESSION['last_activity']) > ADMIN_IDLE_TIMEOUT) {
    session_unset();
    session_destroy();
    header('Location: /admin/login.php?timeout=1');
    exit;
}

$_SESSION['last_activity'] = time();
