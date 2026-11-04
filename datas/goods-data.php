<?php
function spoon_goods_models(): array
{
    static $models = null;
    if ($models !== null) {
        return $models;
    }

    $models = [];
    $source = @file_get_contents(__DIR__ . '/listTovar.js');
    if ($source !== false
        && preg_match('/goods\.models\s*=\s*(\[.*\])\s*;?\s*$/s', $source, $matches)
        && is_array($decoded = json_decode($matches[1], true))) {
        $models = $decoded;
    }

    return $models;
}

function spoon_translit(string $text): string
{
    $map = [
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'e',
        'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm',
        'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u',
        'ф' => 'f', 'х' => 'h', 'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch', 'ъ' => '',
        'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
    ];
    $text = mb_strtolower($text, 'UTF-8');
    $text = strtr($text, $map);
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim((string)$text, '-');
}

function spoon_product_title(string $id, array $product): string
{
    $name = trim((string)($product['name'] ?? ''));
    if (preg_match('/^"(.*)"$/u', $name, $matches)) {
        $name = '«' . $matches[1] . '»';
    }

    if (strpos($id, 'c6_') === 0) {
        return trim('Столовые приборы ' . $name . ' с гравировкой');
    }

    $category = trim((string)($product['cat_name'] ?? ''));
    return trim($category . ' ' . $name);
}

function spoon_product_slug(string $id, array $product): string
{
    $slug = trim((string)($product['slug'] ?? ''));
    if ($slug === '') {
        $slug = spoon_translit(spoon_product_title($id, $product));
    }
    if ($slug === '') {
        $slug = 'tovar-' . str_replace('_', '-', $id);
    }
    return $slug;
}

function spoon_find_product(string $slug): ?array
{
    foreach (spoon_goods_models() as $group) {
        foreach ($group as $id => $product) {
            if (spoon_product_slug($id, $product) === $slug) {
                $product['id'] = $id;
                $product['slug'] = $slug;
                return $product;
            }
        }
    }
    return null;
}

function spoon_plain_text(?string $html): string
{
    $text = strip_tags((string)$html);
    $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $text = preg_replace('/\s+/u', ' ', $text);
    return trim((string)$text);
}

function spoon_meta_description(string $id, array $product): string
{
    $plain = spoon_plain_text($product['description'] ?? '');
    if ($plain === '') {
        return 'Купить ' . spoon_product_title($id, $product) . ' оптом от '
            . trim((string)($product['price'] ?? ''))
            . ' руб. Гравировка по макету заказчика, доставка по России и СНГ.';
    }
    $text = mb_substr($plain, 0, 160);
    $lastSpace = mb_strrpos($text, ' ');
    if ($lastSpace !== false) {
        $text = mb_substr($text, 0, $lastSpace);
    }
    return rtrim($text, " ,.;:—-") . '…';
}

function spoon_render_goods(string $category, ?string $excludeId = null, int $limit = 0): void
{
    $rendered = 0;

    foreach (spoon_goods_models() as $group) {
        foreach ($group as $id => $product) {
            if (strpos($id, $category . '_') !== 0 || $id === $excludeId) {
                continue;
            }
            if ($limit > 0 && $rendered >= $limit) {
                return;
            }

            $catName = spoon_h($product['cat_name'] ?? '');
            $name = spoon_h($product['name'] ?? '');
            $price = spoon_h($product['price'] ?? '');
            $img = spoon_h($product['img'] ?? '');
            $alt = spoon_h(spoon_product_title($id, $product));
            $url = spoon_h(spoon_product_slug($id, $product));

            echo '<div class="col-lg-4 col-md-4 col-xs-6">'
                . '<div class="goods-boots-info model-box" data-id="' . spoon_h($id) . '">'
                . '<div class="buttons">'
                . '<a href="' . $url . '" class="readmore"><p>' . $catName . '</p><h4>' . $name . '</h4></a>'
                . '<a href="' . $url . '"><img style="aspect-ratio: 292/190" src="' . $img . '" width="100%" alt="' . $alt . '"/></a>'
                . '<div class="photobuttons online"><a onclick="showBig(event)" title="На весь экран">☐</a></div>'
                . '<div class="tovar_info">'
                . '<div title="Указанная цена действует на крупные оптовые заказы" class="price price-txt">от <span>' . $price . '</span> руб.*</div>'
                . '<div class="readmore"><a href="' . $url . '">Подробнее</a></div>'
                . '</div></div></div></div>';

            $rendered++;
        }
    }
}
