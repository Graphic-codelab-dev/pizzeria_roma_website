<?php
/**
 * Sistema bilingüe EN/FR. Las rutas localizadas (/en/..., /fr/...) pasan
 * el idioma vía ?lang=, inyectado por .htaccess / router.php.
 */

const SUPPORTED_LANGS = ['en', 'fr'];
const DEFAULT_LANG = 'en';

function resolve_lang(): string
{
    $lang = $_GET['lang'] ?? $_COOKIE['pr_lang'] ?? DEFAULT_LANG;

    if (!in_array($lang, SUPPORTED_LANGS, true)) {
        $lang = DEFAULT_LANG;
    }

    if (($_COOKIE['pr_lang'] ?? null) !== $lang) {
        setcookie('pr_lang', $lang, [
            'expires'  => time() + 60 * 60 * 24 * 365,
            'path'     => '/',
            'samesite' => 'Lax',
        ]);
    }

    return $lang;
}

function load_translations(string $lang): array
{
    static $cache = [];
    if (isset($cache[$lang])) {
        return $cache[$lang];
    }

    $file = ROOT_PATH . "/lang/{$lang}.php";
    return $cache[$lang] = is_file($file) ? require $file : [];
}

/**
 * Busca una clave con notación de puntos ("nav.home") dentro del
 * diccionario de traducciones. Si no existe, devuelve la clave misma
 * para que un texto faltante sea visible y fácil de detectar.
 */
function t(array $translations, string $key, array $vars = []): string
{
    $value = $translations;
    foreach (explode('.', $key) as $segment) {
        if (!is_array($value) || !array_key_exists($segment, $value)) {
            return $key;
        }
        $value = $value[$segment];
    }

    if (!is_string($value)) {
        return $key;
    }

    return $vars ? strtr($value, $vars) : $value;
}

/** Construye una URL localizada, ej. lang_url('fr', 'menu') -> /fr/menu */
function lang_url(string $lang, string $path = ''): string
{
    $path = trim($path, '/');
    return '/' . $lang . ($path !== '' ? '/' . $path : '/');
}
