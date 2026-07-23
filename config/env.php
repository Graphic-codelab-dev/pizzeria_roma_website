<?php
/**
 * Loader de variables de entorno único y compartido para todo el sitio
 * (unifica el patrón disperso que existía en el proyecto de referencia).
 */

function load_env(string $path): array
{
    static $cache = [];
    if (isset($cache[$path])) {
        return $cache[$path];
    }

    $vars = [];
    if (is_file($path)) {
        foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            $line = trim($line);
            if ($line === '' || $line[0] === '#' || strpos($line, '=') === false) {
                continue;
            }
            [$key, $value] = explode('=', $line, 2);
            $vars[trim($key)] = trim($value, " \t\n\r\0\x0B\"'");
        }
    }

    foreach ($vars as $key => $value) {
        if (getenv($key) === false) {
            putenv("{$key}={$value}");
        }
    }

    return $cache[$path] = $vars;
}

function env(string $key, $default = null)
{
    $value = getenv($key);
    return $value === false ? $default : $value;
}
