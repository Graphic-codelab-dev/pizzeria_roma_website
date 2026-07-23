<?php
require_once dirname(__DIR__) . '/config/bootstrap.php';

$seo = [
    'title'       => t($t, 'meta.about_title'),
    'description' => t($t, 'meta.about_description'),
    'path'        => 'about',
    'css'         => ['home.css', 'about.css'],
];

$root = ROOT_PATH;
include $root . '/components/head.php';
?>
<body class="page-about">

<?php include $root . '/components/header.php'; ?>

<main id="main">
<?php
include $root . '/sections/about/hero.php';
include $root . '/sections/about/story.php';
include $root . '/sections/about/oven.php';
include $root . '/sections/home/events.php';
include $root . '/sections/about/team.php';
include $root . '/components/cta-call.php';
?>
</main>

<?php include $root . '/components/footer.php'; ?>
<?php include $root . '/components/scripts.php'; ?>
</body>
</html>
