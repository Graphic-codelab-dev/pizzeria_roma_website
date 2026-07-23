<?php
/**
 * Bootstrap del panel de admin: sesión endurecida + entorno.
 * El admin es de un solo idioma (inglés) — no usa config/bootstrap.php
 * ni el sistema i18n público.
 */

declare(strict_types=1);

if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(__DIR__, 2));
}

require_once ROOT_PATH . '/config/env.php';
load_env(ROOT_PATH . '/.env');

if (session_status() === PHP_SESSION_NONE) {
    session_name(env('ADMIN_SESSION_NAME', 'pr_admin_session'));
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/admin',
        'httponly' => true,
        'samesite' => 'Strict',
        'secure'   => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    ]);
    session_start();
}
