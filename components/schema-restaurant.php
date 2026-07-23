<?php
/**
 * Nodo base de schema.org Restaurant/LocalBusiness, incluido en TODAS
 * las páginas públicas (ver components/head.php). Cada página añade
 * sus propios nodos adicionales (FAQPage, Menu, BreadcrumbList) vía
 * $seo['schema'].
 */
function restaurant_schema(string $siteUrl): array
{
    return [
        '@context' => 'https://schema.org',
        '@type'    => 'Restaurant',
        '@id'      => $siteUrl . '/#restaurant',
        'name'     => 'Pizzeria Roma',
        'image'    => $siteUrl . '/assets/images/logo/og-image.jpg',
        'url'      => $siteUrl,
        'telephone' => '+1-705-222-7662',
        'servesCuisine' => ['Italian', 'Pizza'],
        'priceRange'    => '$$',
        'address' => [
            '@type'           => 'PostalAddress',
            'streetAddress'   => '1507 Paris St',
            'addressLocality' => 'Greater Sudbury',
            'addressRegion'   => 'ON',
            'postalCode'      => 'P3E 3B7',
            'addressCountry'  => 'CA',
        ],
        'openingHoursSpecification' => [
            [
                '@type'    => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday'],
                'opens'    => '11:00',
                'closes'   => '21:00',
            ],
            [
                '@type'    => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Friday', 'Saturday'],
                'opens'    => '11:00',
                'closes'   => '22:00',
            ],
            [
                '@type'    => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Sunday'],
                'opens'    => '12:00',
                'closes'   => '21:00',
            ],
        ],
        'aggregateRating' => [
            '@type'       => 'AggregateRating',
            'ratingValue' => '4.4',
            'reviewCount' => '60',
            'bestRating'  => '5',
        ],
        'hasMenu' => $siteUrl . '/en/menu',
        // Vincula el mismo negocio entre plataformas — ayuda a Google y a
        // motores generativos (ChatGPT, Perplexity...) a consolidar la
        // entidad "Pizzeria Roma" en una sola ficha con las mismas señales
        // (reseñas, horarios, fotos) que ya se usan en el resto del sitio.
        'sameAs' => [
            'https://www.facebook.com/www.pizzeriaroma.ca/?locale=es_LA',
            'https://www.instagram.com/pizzeriaroma1894/?hl=es',
            'https://www.tripadvisor.ca/Restaurant_Review-g155016-d23126910-Reviews-Pizzeria_Roma-Sudbury_Northeastern_Ontario_Ontario.html',
        ],
        'hasMap' => 'https://www.google.com/maps?q=1507+Paris+St,+Greater+Sudbury,+ON+P3E+3B7',
    ];
}
