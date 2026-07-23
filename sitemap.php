<?php
/**
 * Genera sitemap.xml dinámicamente para las páginas públicas en ambos
 * idiomas, con enlaces hreflang alternos. Servido en /sitemap.xml
 * vía .htaccess / router.php.
 */

require_once __DIR__ . '/config/env.php';
load_env(__DIR__ . '/.env');

$siteUrl = rtrim(env('SITE_URL', 'https://pizzeriaroma.ca'), '/');

$paths = ['', 'menu', 'about', 'contact'];
$langs = ['en', 'fr'];

$priorities = ['' => '1.0', 'menu' => '0.9', 'about' => '0.7', 'contact' => '0.7'];
$changefreq = ['' => 'weekly', 'menu' => 'weekly', 'about' => 'monthly', 'contact' => 'monthly'];

$templates = ['' => 'pages/home.php', 'menu' => 'pages/menu.php', 'about' => 'pages/about.php', 'contact' => 'pages/contact.php'];
$lastmod   = [];
foreach ($templates as $path => $template) {
    $lastmod[$path] = filemtime(__DIR__ . '/' . $template) ?: time();
}

// Para /menu, refleja la última vez que cambió el catálogo (productos o
// categorías) desde el admin, si es más reciente que el propio template.
try {
    $pdo = require __DIR__ . '/config/db.php';
    $latestProductChange = $pdo->query(
        "SELECT GREATEST(
            COALESCE((SELECT MAX(updated_at) FROM products), '1970-01-01'),
            COALESCE((SELECT MAX(updated_at) FROM categories), '1970-01-01')
        )"
    )->fetchColumn();
    if ($latestProductChange) {
        $lastmod['menu'] = max($lastmod['menu'], strtotime($latestProductChange));
    }
} catch (Throwable $e) {
    // BD no disponible: se mantiene el lastmod basado en el archivo.
}

header('Content-Type: application/xml; charset=UTF-8');

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xhtml="http://www.w3.org/1999/xhtml">
<?php foreach ($paths as $path): ?>
<?php foreach ($langs as $lang): ?>
<?php $loc = $siteUrl . '/' . $lang . ($path !== '' ? '/' . $path : '/'); ?>
  <url>
    <loc><?= htmlspecialchars($loc) ?></loc>
<?php foreach ($langs as $altLang): ?>
<?php $altLoc = $siteUrl . '/' . $altLang . ($path !== '' ? '/' . $path : '/'); ?>
    <xhtml:link rel="alternate" hreflang="<?= $altLang ?>" href="<?= htmlspecialchars($altLoc) ?>" />
<?php endforeach; ?>
    <xhtml:link rel="alternate" hreflang="x-default" href="<?= htmlspecialchars($siteUrl . '/en' . ($path !== '' ? '/' . $path : '/')) ?>" />
    <lastmod><?= date('c', $lastmod[$path]) ?></lastmod>
    <changefreq><?= $changefreq[$path] ?></changefreq>
    <priority><?= $priorities[$path] ?></priority>
  </url>
<?php endforeach; ?>
<?php endforeach; ?>
</urlset>
