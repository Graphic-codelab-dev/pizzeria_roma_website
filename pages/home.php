<?php
require_once dirname(__DIR__) . '/config/bootstrap.php';

$faqItems = $t['home']['faq'] ?? [];

$seo = [
    'title'       => t($t, 'meta.home_title'),
    'description' => t($t, 'meta.home_description'),
    'path'        => '',
    'css'         => ['home.css'],
    'schema'      => [
        [
            '@context'   => 'https://schema.org',
            '@type'      => 'FAQPage',
            'mainEntity' => array_map(static function (array $item): array {
                return [
                    '@type'          => 'Question',
                    'name'           => $item['q'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text'  => $item['a'],
                    ],
                ];
            }, $faqItems),
        ],
    ],
];

$root = ROOT_PATH;
include $root . '/components/head.php';
?>
<body class="page-home">

<?php include $root . '/components/header.php'; ?>

<main id="main">
<?php
include $root . '/sections/home/hero.php';
include $root . '/sections/home/value-prop.php';
include $root . '/sections/home/menu-preview.php';
include $root . '/sections/home/delivery.php';
include $root . '/sections/home/events.php';
include $root . '/sections/home/reviews.php';
include $root . '/sections/home/faq.php';
include $root . '/components/cta-call.php';
?>
</main>
 
<?php include $root . '/components/footer.php'; ?>
<?php include $root . '/components/scripts.php'; ?>
</body>
</html>
