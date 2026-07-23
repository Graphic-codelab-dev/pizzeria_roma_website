<?php
/**
 * $seo esperado (definido por cada página antes del include):
 *   title, description, path, css[], js[], schema[], og_image
 * Requiere $lang, $t, ROOT_PATH ya definidos por config/bootstrap.php.
 */

$seo = array_merge([
    'title'       => 'Pizzeria Roma — Wood-Fired Pizza in Sudbury, Ontario',
    'description' => 'Authentic wood-fired pizza in Sudbury, Ontario.',
    'path'        => '',
    'css'         => [],
    'js'          => [],
    'schema'      => [],
    'og_image'    => '/assets/images/logo/og-image.jpg',
], $seo ?? []);

$siteUrl = rtrim(env('SITE_URL', 'https://pizzeriaroma.ca'), '/');
$path    = trim($seo['path'], '/');
$suffix  = $path !== '' ? '/' . $path : '/';

$canonical = $siteUrl . '/' . $lang . $suffix;
$hrefEn    = $siteUrl . '/en' . $suffix;
$hrefFr    = $siteUrl . '/fr' . $suffix;

// Grafo de schema.org: Restaurant en todas las páginas + BreadcrumbList
// (excepto home/404) + lo que cada página añada en $seo['schema'].
require_once ROOT_PATH . '/components/schema-restaurant.php';
$schemaGraph = [restaurant_schema($siteUrl)];

if ($path !== '' && $path !== '404') {
    $breadcrumbLabels = ['menu' => 'nav.menu', 'about' => 'nav.about', 'contact' => 'nav.contact'];
    $schemaGraph[] = [
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => [
            [
                '@type'    => 'ListItem',
                'position' => 1,
                'name'     => t($t, 'nav.home'),
                'item'     => $siteUrl . '/' . $lang . '/',
            ],
            [
                '@type'    => 'ListItem',
                'position' => 2,
                'name'     => t($t, $breadcrumbLabels[$path] ?? 'nav.home'),
                'item'     => $canonical,
            ],
        ],
    ];
}

$schemaGraph = array_merge($schemaGraph, $seo['schema']);
?><!DOCTYPE html>
<html lang="<?= $lang === 'fr' ? 'fr-CA' : 'en-CA' ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($seo['title']) ?></title>
<meta name="description" content="<?= htmlspecialchars($seo['description']) ?>">
<link rel="canonical" href="<?= htmlspecialchars($canonical) ?>">
<link rel="alternate" hreflang="en" href="<?= htmlspecialchars($hrefEn) ?>">
<link rel="alternate" hreflang="fr" href="<?= htmlspecialchars($hrefFr) ?>">
<link rel="alternate" hreflang="x-default" href="<?= htmlspecialchars($hrefEn) ?>">
<?php if ($path === '404'): ?>
<meta name="robots" content="noindex, follow">
<?php endif; ?>

<meta property="og:type" content="website">
<meta property="og:site_name" content="Pizzeria Roma">
<meta property="og:title" content="<?= htmlspecialchars($seo['title']) ?>">
<meta property="og:description" content="<?= htmlspecialchars($seo['description']) ?>">
<meta property="og:url" content="<?= htmlspecialchars($canonical) ?>">
<meta property="og:image" content="<?= htmlspecialchars($siteUrl . $seo['og_image']) ?>">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="Pizzeria Roma — wood-fired pizza">
<meta property="og:locale" content="<?= $lang === 'fr' ? 'fr_CA' : 'en_CA' ?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= htmlspecialchars($seo['title']) ?>">
<meta name="twitter:description" content="<?= htmlspecialchars($seo['description']) ?>">
<meta name="twitter:image" content="<?= htmlspecialchars($siteUrl . $seo['og_image']) ?>">

<meta name="geo.region" content="CA-ON">
<meta name="geo.placename" content="Sudbury">

<link rel="icon" href="/assets/images/logo/logocolor.svg" type="image/svg+xml">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&display=swap">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&display=swap">

<!-- CSS crítico (tokens + reset) inline para evitar un round-trip render-blocking -->
<style nonce="<?= htmlspecialchars($cspNonce) ?>"><?= file_get_contents(ROOT_PATH . '/css/tokens.css') ?></style>
<style nonce="<?= htmlspecialchars($cspNonce) ?>"><?= file_get_contents(ROOT_PATH . '/css/base.css') ?></style>

<?php foreach (['utilities.css', 'animations.css', 'components.css'] as $_css): ?>
<link rel="stylesheet" href="/css/<?= $_css ?>?v=<?= filemtime(ROOT_PATH . '/css/' . $_css) ?>">
<?php endforeach; ?>
<?php foreach ($seo['css'] as $_pageCss): ?>
<link rel="stylesheet" href="/css/<?= htmlspecialchars($_pageCss) ?>?v=<?= filemtime(ROOT_PATH . '/css/' . $_pageCss) ?>">
<?php endforeach; ?>

<?php foreach ($schemaGraph as $_schemaNode): ?>
<script type="application/ld+json"><?= json_encode($_schemaNode, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) ?></script>
<?php endforeach; ?>
</head>
