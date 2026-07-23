<?php
require_once dirname(__DIR__) . '/config/bootstrap.php';

$categories = [];

try {
    $pdo = require ROOT_PATH . '/config/db.php';

    $categories = $pdo->query(
        'SELECT * FROM categories WHERE is_active = 1 ORDER BY display_order ASC'
    )->fetchAll();

    $allProducts = $pdo->query(
        'SELECT * FROM products WHERE is_active = 1 ORDER BY display_order ASC'
    )->fetchAll();

    foreach ($categories as &$cat) {
        $cat['products'] = array_values(array_filter(
            $allProducts,
            static fn (array $p): bool => (int) $p['category_id'] === (int) $cat['id']
        ));
    }
    unset($cat);
} catch (Throwable $e) {
    $categories = [];
}

$nonEmptyCategories = array_values(array_filter(
    $categories,
    static fn (array $cat): bool => !empty($cat['products'])
));

$menuSchema = [
    '@context'      => 'https://schema.org',
    '@type'         => 'Menu',
    'name'          => 'Pizzeria Roma Menu',
    'hasMenuSection' => array_map(static function (array $cat) use ($lang): array {
        return [
            '@type'       => 'MenuSection',
            'name'        => $lang === 'fr' ? $cat['name_fr'] : $cat['name_en'],
            'hasMenuItem' => array_map(static function (array $p) use ($lang): array {
                return [
                    '@type'       => 'MenuItem',
                    'name'        => $lang === 'fr' ? $p['name_fr'] : $p['name_en'],
                    'description' => $lang === 'fr' ? $p['description_fr'] : $p['description_en'],
                    'offers'      => [
                        '@type'         => 'Offer',
                        'price'         => number_format((float) $p['price'], 2, '.', ''),
                        'priceCurrency' => 'CAD',
                    ],
                ];
            }, $cat['products']),
        ];
    }, $nonEmptyCategories),
];

$seo = [
    'title'       => t($t, 'meta.menu_title'),
    'description' => t($t, 'meta.menu_description'),
    'path'        => 'menu',
    'css'         => ['menu.css'],
    'js'          => ['menu.js', 'order-modal.js'],
    'schema'      => $nonEmptyCategories ? [$menuSchema] : [],
];

$root = ROOT_PATH;
include $root . '/components/head.php';
?>
<body class="page-menu">

<?php include $root . '/components/header.php'; ?>

<main id="main">
<?php
include $root . '/sections/menu/hero.php';
include $root . '/sections/menu/shop.php';
?>
</main>

<?php include $root . '/components/order-modal.php'; ?>

<?php include $root . '/components/footer.php'; ?>
<?php include $root . '/components/scripts.php'; ?>
</body>
</html>
