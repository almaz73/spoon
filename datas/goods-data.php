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

function spoon_h(?string $value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function spoon_render_goods(string $category): void
{
    foreach (spoon_goods_models() as $group) {
        foreach ($group as $id => $product) {
            if (strpos($id, $category . '_') !== 0) {
                continue;
            }

            $catName = spoon_h($product['cat_name'] ?? '');
            $name = spoon_h($product['name'] ?? '');
            $price = spoon_h($product['price'] ?? '');
            $img = spoon_h($product['img'] ?? '');

            echo '<div class="col-lg-4 col-md-4 col-xs-6">'
                . '<div class="goods-boots-info model-box" data-id="' . spoon_h($id) . '">'
                . '<div class="buttons">'
                . '<a href="#tovar" data-toggle="modal" class="showtovar readmore"><p>' . $catName . '</p><h4>' . $name . '</h4></a>'
                . '<a href="#tovar" data-toggle="modal" class="showtovar readmore"><img style="aspect-ratio: 292/190" src="' . $img . '" width="100%" alt="' . $name . '"/></a>'
                . '<div class="photobuttons online"><a onclick="showBig(event)" title="На весь экран">☐</a></div>'
                . '<div class="tovar_info">'
                . '<div title="Указанная цена действует на крупные оптовые заказы" class="price price-txt">от <span>' . $price . '</span> руб.*</div>'
                . '<div class="readmore"><a href="#tovar" class="showtovar readmore" data-toggle="modal">Подробнее</a></div>'
                . '</div></div></div></div>';
        }
    }
}
