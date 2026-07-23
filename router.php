<?php
/**
 * Router para el servidor de desarrollo integrado de PHP.
 * Uso: php -S localhost:8000 router.php
 * En producción, .htaccess cumple este mismo rol (mantener ambos en sync).
 */

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (preg_match('#^/(config|sql|lang|handlers)(/|$)#', $uri)
    || preg_match('#^/admin/includes(/|$)#', $uri)
) {
    http_response_code(403);
    exit('Forbidden');
}

$routes = [
    '/sitemap.xml' => 'sitemap.php',
    '/en'         => 'pages/home.php?lang=en',
    '/fr'         => 'pages/home.php?lang=fr',
    '/en/menu'    => 'pages/menu.php?lang=en',
    '/fr/menu'    => 'pages/menu.php?lang=fr',
    '/en/about'   => 'pages/about.php?lang=en',
    '/fr/about'   => 'pages/about.php?lang=fr',
    '/en/contact' => 'pages/contact.php?lang=en',
    '/fr/contact' => 'pages/contact.php?lang=fr',
    '/admin'      => 'admin/index.php',
];

$path = rtrim($uri, '/');

if (isset($routes[$path])) {
    [$file, $query] = array_pad(explode('?', $routes[$path], 2), 2, '');
    parse_str($query, $params);
    $_GET = array_merge($_GET, $params);
    require __DIR__ . '/' . $file;
    return true;
}

// Archivo estático real (css, js, imágenes...): que el servidor lo sirva normalmente.
$filePath = __DIR__ . $uri;
if ($uri !== '/' && is_file($filePath)) {
    return false;
}

// Raíz: deja que index.php maneje la detección/redirección de idioma.
if ($path === '') {
    return false;
}

// Cualquier otra ruta sin match real = 404 (mismo comportamiento que .htaccess en producción).
http_response_code(404);
require __DIR__ . '/pages/error-404.php';
return true;
