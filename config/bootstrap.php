<?php
/**
 * Punto de entrada compartido por todas las páginas públicas.
 * Resuelve idioma, carga traducciones y variables de entorno.
 * Uso: require_once dirname(__DIR__) . '/config/bootstrap.php';
 */

declare(strict_types=1);

define('ROOT_PATH', dirname(__DIR__));

$isHttps = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'httponly' => true,
        'samesite' => 'Lax',
        'secure'   => $isHttps,
    ]);
    session_start();
}

require_once __DIR__ . '/env.php';
require_once __DIR__ . '/i18n.php';
require_once __DIR__ . '/security-headers.php';

load_env(ROOT_PATH . '/.env');

$lang     = resolve_lang();
$t        = load_translations($lang);
$cspNonce = send_security_headers($isHttps);
