<?php
/**
 * Raíz del sitio: detecta idioma preferido (cookie o Accept-Language)
 * y redirige a la versión localizada. No es un front controller.
 */

require_once __DIR__ . '/config/env.php';
load_env(__DIR__ . '/.env');

$lang = $_COOKIE['pr_lang'] ?? null;

if (!in_array($lang, ['en', 'fr'], true)) {
    $acceptLanguage = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '';
    $lang = stripos(substr($acceptLanguage, 0, 5), 'fr') !== false ? 'fr' : 'en';
}

header('Location: /' . $lang . '/', true, 302);
exit;
