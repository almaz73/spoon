<?php
require __DIR__ . '/datas/goods-data.php';
require_once __DIR__ . '/includes/site.php';

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
if (!in_array($method, ['GET', 'HEAD'], true)) {
    http_response_code(405);
    header('Allow: GET, HEAD');
    exit;
}

$baseUrl = spoon_site_url();
$siteRoot = __DIR__;
$seen = [];
$urls = [];

$pages = [
    'index.php' => ['changefreq' => 'weekly', 'priority' => '1.0'],
    'why.php' => ['changefreq' => 'monthly', 'priority' => '0.8'],
    'catalog.php' => ['changefreq' => 'weekly', 'priority' => '0.9'],
    'reviews.php' => ['changefreq' => 'monthly', 'priority' => '0.7'],
    'certificates.php' => ['changefreq' => 'monthly', 'priority' => '0.6'],
];

foreach ($pages as $file => $meta) {
    $loc = $file === 'index.php' ? $baseUrl : $baseUrl . $file;
    $seen[$loc] = true;
    $mtime = @filemtime($siteRoot . '/' . $file);

    $urls[] = [
        'loc' => $loc,
        'lastmod' => $mtime !== false ? gmdate('Y-m-d', $mtime) : null,
        'changefreq' => $meta['changefreq'],
        'priority' => $meta['priority'],
        'image' => null,
    ];
}

$dataMtime = @filemtime($siteRoot . '/datas/listTovar.js');
$lastmod = $dataMtime !== false ? gmdate('Y-m-d', $dataMtime) : null;

foreach (spoon_goods_models() as $group) {
    foreach ($group as $id => $product) {
        $loc = $baseUrl . spoon_product_slug($id, $product);
        if (isset($seen[$loc])) {
            continue;
        }
        $seen[$loc] = true;

        $image = trim((string)($product['img'] ?? ''));

        $urls[] = [
            'loc' => $loc,
            'lastmod' => $lastmod,
            'changefreq' => 'monthly',
            'priority' => '0.8',
            'image' => $image !== '' ? $baseUrl . ltrim($image, '/') : null,
        ];
    }
}

$escape = static fn(string $value): string => htmlspecialchars($value, ENT_QUOTES | ENT_XML1, 'UTF-8');

header('Content-Type: application/xml; charset=utf-8');
header('Cache-Control: public, max-age=3600');

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";

foreach ($urls as $url) {
    echo "  <url>\n";
    echo '    <loc>' . $escape($url['loc']) . "</loc>\n";
    if ($url['lastmod'] !== null) {
        echo '    <lastmod>' . $escape($url['lastmod']) . "</lastmod>\n";
    }
    echo '    <changefreq>' . $escape($url['changefreq']) . "</changefreq>\n";
    echo '    <priority>' . $escape($url['priority']) . "</priority>\n";
    if ($url['image'] !== null) {
        echo "    <image:image>\n";
        echo '      <image:loc>' . $escape($url['image']) . "</image:loc>\n";
        echo "    </image:image>\n";
    }
    echo "  </url>\n";
}

echo '</urlset>' . "\n";
