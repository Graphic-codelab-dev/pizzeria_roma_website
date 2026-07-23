<?php
/**
 * Servida por .htaccess (ErrorDocument 404). En Apache, REQUEST_URI
 * conserva la URL original que causó el 404, así que el idioma se
 * detecta a partir de su prefijo /en/ o /fr/.
 */

preg_match('#^/(en|fr)(/|$)#', $_SERVER['REQUEST_URI'] ?? '', $m);
$_GET['lang'] = $m[1] ?? 'en';

require_once dirname(__DIR__) . '/config/bootstrap.php';

http_response_code(404);

$seo = [
    'title'       => t($t, 'error404.title'),
    'description' => t($t, 'error404.description'),
    'path'        => '404',
];

$root = ROOT_PATH;
include $root . '/components/head.php';
?>
<body class="page-404">

<?php include $root . '/components/header.php'; ?>

<main id="main" class="u-container u-section u-text-center">
  <h1><?= htmlspecialchars(t($t, 'error404.heading')) ?></h1>
  <p class="u-text-muted"><?= htmlspecialchars(t($t, 'error404.body')) ?></p>
  <p style="margin-top: var(--space-md);">
    <a class="btn btn--primary" href="<?= lang_url($lang) ?>"><?= htmlspecialchars(t($t, 'common.home')) ?></a>
  </p>
</main>

<?php include $root . '/components/footer.php'; ?>
<?php include $root . '/components/scripts.php'; ?>
</body>
</html>
