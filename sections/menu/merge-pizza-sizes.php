<?php
declare(strict_types=1);

/**
 * Pizzas viven en la BD como filas duplicadas por tamaño (categorías
 * pizzas-12 / pizzas-15 / pizzas-16, mismo nombre base con el tamaño
 * como prefijo). Estas funciones las fusionan en una sola tarjeta por
 * pizza, con un arreglo `sizes` que alimenta el selector de tamaño y
 * el desglose de precios por plataforma en el popup de pedido.
 */

/** Quita el tamaño del nombre — inglés lo antepone ('12" Foo'), francés lo pospone ('Foo 12 po'). */
function menu_strip_size_prefix(string $name): string
{
    $name = (string) preg_replace('/^\d+"\s*/u', '', $name);
    $name = (string) preg_replace('/\s+\d+\s*(?:"|po)\s*$/iu', '', $name);
    return trim($name);
}

/** Lista de plataformas (en el orden de config/delivery-platforms.php) con precio para este producto; omite las que no lo venden. */
function menu_platform_list_for_product(int $productId, array $platformPricesByProduct): array
{
    static $deliveryPlatforms = null;
    if ($deliveryPlatforms === null) {
        $deliveryPlatforms = require ROOT_PATH . '/config/delivery-platforms.php';
    }

    $prices = $platformPricesByProduct[$productId] ?? [];
    $list   = [];
    foreach ($deliveryPlatforms as $platform) {
        if (!isset($prices[$platform['key']])) {
            continue;
        }
        $list[] = [
            'key'        => $platform['key'],
            'name'       => $platform['name'],
            'logo'       => $platform['logo'],
            'url'        => $platform['url'],
            'price'      => number_format($prices[$platform['key']]['price'], 2, '.', ''),
            'isEstimate' => $prices[$platform['key']]['is_placeholder'],
        ];
    }
    return $list;
}

/** Payload del popup para un producto de tamaño único (todo lo que no es pizza). */
function menu_build_single_size_payload(array $p, string $lang, array $platformPricesByProduct): array
{
    $name = $lang === 'fr' ? $p['name_fr'] : $p['name_en'];
    return [
        'name'  => $name,
        'sizes' => [[
            'label'           => null,
            'price'           => number_format((float) $p['price'], 2, '.', ''),
            'priceIsEstimate' => (bool) ($p['is_price_placeholder'] ?? false),
            'platforms'       => menu_platform_list_for_product((int) $p['id'], $platformPricesByProduct),
        ]],
    ];
}

/**
 * Fusiona una categoría "primaria" con una o más categorías de tamaño/porción
 * en tarjetas únicas (mismo patrón usado por pizzas: pizzas-12/15/16, y
 * reutilizado para Panzerotti y Ensaladas por porción/familiar).
 *
 * @param array<string,string> $sizeSlugs Mapa etiqueta => slug, en orden de
 *   aparición en el selector (sin incluir la etiqueta primaria).
 */
function menu_merge_sized_products(
    array $categories,
    array $platformPricesByProduct,
    string $lang,
    string $primarySlug,
    string $primaryLabel,
    array $sizeSlugs
): array {
    $bySlug = [];
    foreach ($categories as $idx => $cat) {
        $bySlug[$cat['slug']] = $idx;
    }

    if (!isset($bySlug[$primarySlug])) {
        return $categories;
    }

    $bySize = [];
    foreach ($sizeSlugs as $label => $slug) {
        if (!isset($bySlug[$slug])) {
            continue;
        }
        foreach ($categories[$bySlug[$slug]]['products'] as $p) {
            $bySize[$label][menu_strip_size_prefix($p['name_en'])] = $p;
        }
    }

    $primaryIdx      = $bySlug[$primarySlug];
    $mergedProducts  = [];
    $labelOrder      = array_merge([$primaryLabel], array_keys($sizeSlugs));

    foreach ($categories[$primaryIdx]['products'] as $primary) {
        $baseNameEn = menu_strip_size_prefix($primary['name_en']);
        $baseNameFr = menu_strip_size_prefix($primary['name_fr']);

        $sizes = [$primaryLabel => $primary];
        foreach ($bySize as $label => $productsByName) {
            if (isset($productsByName[$baseNameEn])) {
                $sizes[$label] = $productsByName[$baseNameEn];
            }
        }

        $sizePayload = [];
        $isFeatured  = false;
        $minPrice    = null;
        foreach ($labelOrder as $label) {
            if (!isset($sizes[$label])) {
                continue;
            }
            $sp         = $sizes[$label];
            $isFeatured = $isFeatured || !empty($sp['is_featured']);
            $price      = (float) $sp['price'];
            $minPrice   = $minPrice === null ? $price : min($minPrice, $price);

            $sizePayload[] = [
                'label'           => $label,
                'price'           => number_format($price, 2, '.', ''),
                'priceIsEstimate' => (bool) ($sp['is_price_placeholder'] ?? false),
                'platforms'       => menu_platform_list_for_product((int) $sp['id'], $platformPricesByProduct),
            ];
        }

        $merged                  = $primary;
        $merged['name_en']       = $baseNameEn;
        $merged['name_fr']       = $baseNameFr;
        $merged['price']         = $minPrice;
        $merged['price_is_from'] = count($sizePayload) > 1;
        $merged['is_featured']   = $isFeatured ? 1 : 0;
        $merged['order_payload'] = [
            'name'  => $lang === 'fr' ? $baseNameFr : $baseNameEn,
            'sizes' => $sizePayload,
        ];

        $mergedProducts[] = $merged;
    }

    $categories[$primaryIdx]['products'] = $mergedProducts;

    foreach ($sizeSlugs as $slug) {
        if (isset($bySlug[$slug])) {
            unset($categories[$bySlug[$slug]]);
        }
    }

    return array_values($categories);
}

/** Fusiona pizzas-12 / pizzas-15 / pizzas-16 en tarjetas únicas dentro de pizzas-12. */
function menu_merge_pizza_sizes(array $categories, array $platformPricesByProduct, string $lang): array
{
    return menu_merge_sized_products(
        $categories,
        $platformPricesByProduct,
        $lang,
        'pizzas-12',
        '12"',
        ['15"' => 'pizzas-15', '16"' => 'pizzas-16']
    );
}
