<?php
require_once dirname(__DIR__) . '/config/bootstrap.php';

$seo = [
    'title'       => t($t, 'meta.contact_title'),
    'description' => t($t, 'meta.contact_description'),
    'path'        => 'contact',
    'css'         => ['contact.css'],
    'js'          => ['contact.js'],
];

$root = ROOT_PATH;
include $root . '/components/head.php';
?>
<body class="page-contact">

<?php include $root . '/components/header.php'; ?>

<main id="main">
<?php
include $root . '/sections/contact/hero.php';
include $root . '/sections/contact/info.php';
include $root . '/sections/contact/form.php';
include $root . '/sections/contact/map.php';
?>
</main>

<?php include $root . '/components/footer.php'; ?>
<?php include $root . '/components/scripts.php'; ?>
</body>
</html>
