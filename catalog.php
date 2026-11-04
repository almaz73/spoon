<?php
require __DIR__ . '/datas/goods-data.php';

$pageTitle = 'Каталог товаров — столовые приборы и сувениры с гравировкой';
$pageDescription = 'Каталог продукции «Ложкин Дом»: столовые приборы серий «Тройка», «Славянка», «Торжество», а также фляжки, брелоки, зеркала и Power Bank с гравировкой. Цены от производителя.';
include 'includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <?php spoon_breadcrumbs([
            ['name' => 'Главная', 'href' => 'index.php'],
            ['name' => 'Каталог товаров'],
        ]); ?>
        <h1>Каталог товаров</h1>
        <p class="page-lead">Столовые приборы из нержавеющей стали и другие сувениры с гравировкой. Указанные цены
            действуют на крупные оптовые заказы, актуальный прайс-лист доступен для скачивания.</p>
    </div>
</section>

<section id="price-link" style="position: sticky; top: 50px; z-index: 10; background-color: white; padding: 10px 0">
    <div class="container">
        <div class="row center">
            <div style="font-weight: 600;font-size: 2em;color: red;">Актуальные цены</div>
            <a href="https://drive.google.com/drive/folders/1bwCFjZ5rmdsT7n4TDOWu7krMaYHLlRPY?usp=drive_link"
               style="font-weight: 400;font-size: 1.3em;padding: 20px"
               target="_blank" rel="noopener">Скачать прайс-лист</a>
        </div>
    </div>
</section>

<section id="catalog" class="page-section dark">
    <div class="container">
        <div class="row">
            <h2 class="page-heading">Столовые приборы с гравировкой</h2>
        </div>
        <div class="goods-list row" id="c6"><?php spoon_render_goods('c6'); ?></div>
        <div class="row">
            <h2 class="page-heading">Другие сувениры</h2>
        </div>
        <div class="goods-list row" id="c1"><?php spoon_render_goods('c1'); ?></div>
    </div>
</section>

<section class="page-section light">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <h2 class="page-heading dark">Как заказать продукцию</h2>
                <p class="page-text">Выберите модель в каталоге и нажмите «Подробнее» — откроется страница товара с
                    описанием, фотографиями и формой заявки. Менеджер свяжется с вами, уточнит детали гравировки и
                    вышлет полный прайс-лист.</p>
                <p class="page-text">Возможна гравировка надписей, логотипов, узоров и фотографий на изделиях из
                    нержавеющей стали. Доставка осуществляется по России и странам СНГ.</p>
                <p class="center"><a class="btn mybtn" onclick="callBack()" href="#">Заказать звонок</a></p>
            </div>
        </div>
    </div>
</section>

<?php
$catalogItems = [];
$position = 1;
foreach (spoon_goods_models() as $group) {
    foreach ($group as $id => $product) {
        $url = spoon_site_url() . spoon_product_slug($id, $product);
        $catalogItems[] = [
            '@type' => 'ListItem',
            'position' => $position++,
            'item' => [
                '@type' => 'Product',
                'name' => spoon_product_title($id, $product),
                'url' => $url,
                'image' => spoon_site_url() . ltrim((string)($product['img'] ?? ''), '/'),
                'offers' => [
                    '@type' => 'Offer',
                    'price' => (float)($product['price'] ?? 0),
                    'priceCurrency' => 'RUB',
                    'availability' => 'https://schema.org/InStock',
                    'url' => $url,
                ],
            ],
        ];
    }
}
?>
<script type="application/ld+json"><?= spoon_json_ld([
    '@context' => 'https://schema.org',
    '@type' => 'ItemList',
    'name' => 'Каталог товаров «Ложкин Дом»',
    'numberOfItems' => count($catalogItems),
    'itemListElement' => $catalogItems,
]) ?></script>

<?php include 'includes/footer.php'; ?>
