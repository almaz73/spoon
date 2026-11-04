<?php
require __DIR__ . '/datas/goods-data.php';
require_once __DIR__ . '/includes/site.php';

$slug = trim((string)($_GET['slug'] ?? ''));

// Старые/прямые ссылки вида product.php?slug=... ведём на ЧПУ
$requestPath = strtok($_SERVER['REQUEST_URI'] ?? '', '?');
if ($slug !== '' && strpos((string)$requestPath, 'product.php') !== false) {
    header('Location: ' . $slug, true, 301);
    exit;
}

$product = $slug !== '' ? spoon_find_product($slug) : null;

if ($product === null) {
    http_response_code(404);
    $pageTitle = 'Товар не найден — «Ложкин Дом»';
    $pageDescription = 'Запрашиваемая страница товара не найдена. Перейдите в каталог продукции «Ложкин Дом».';
    $pageRobots = 'noindex,follow';
    $currentPage = 'catalog.php';
    include 'includes/header.php';
    ?>
    <section class="page-hero">
        <div class="container">
            <h1>Товар не найден</h1>
            <p class="page-lead">Возможно, страница устарела или адрес введён с ошибкой. Откройте каталог, чтобы
                выбрать другую продукцию.</p>
        </div>
    </section>
    <section class="page-section light">
        <div class="container center">
            <p><a class="btn mybtn" href="catalog.php">Перейти в каталог товаров</a></p>
        </div>
    </section>
    <?php
    include 'includes/footer.php';
    exit;
}

$productTitle = spoon_product_title($product['id'], $product);
$pageTitle = $productTitle . ' — купить оптом | Ложкин Дом';
$pageDescription = spoon_meta_description($product['id'], $product);
$currentPage = 'catalog.php';
$ogType = 'product';
$plainDescription = spoon_plain_text($product['description'] ?? '');

$photoPaths = $product['photos']['all'] ?? [];
if (!is_array($photoPaths) || $photoPaths === []) {
    $photoPaths = [$product['img'] ?? ''];
}

$photos = [];
foreach ($photoPaths as $photoPath) {
    $photoPath = (string)$photoPath;
    $file = __DIR__ . '/' . ltrim($photoPath, '/');
    $size = $photoPath !== '' && is_file($file) ? @getimagesize($file) : false;
    if ($size !== false) {
        $photos[] = [
            'src' => $photoPath,
            'w' => $size[0],
            'h' => $size[1],
        ];
    }
}

$mainPhoto = $photos[0] ?? ['src' => (string)($product['img'] ?? ''), 'w' => null, 'h' => null];
$pageImage = spoon_site_url() . ltrim($mainPhoto['src'], '/');

$canonicalUrl = spoon_current_url();
$price = trim((string)($product['price'] ?? ''));
$isCutlery = strpos($product['id'], 'c6_') === 0;

$productSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'Product',
    'name' => $productTitle,
    'sku' => $product['id'],
    'image' => array_map(static function (array $photo): string {
        return spoon_site_url() . ltrim($photo['src'], '/');
    }, $photos),
    'description' => $plainDescription !== '' ? $plainDescription : $productTitle,
    'category' => $isCutlery ? 'Столовые приборы с гравировкой' : 'Сувениры с гравировкой',
    'brand' => [
        '@type' => 'Brand',
        'name' => 'Ложкин Дом',
    ],
    'offers' => [
        '@type' => 'AggregateOffer',
        'priceCurrency' => 'RUB',
        'lowPrice' => (float)$price,
        'availability' => 'https://schema.org/InStock',
        'url' => $canonicalUrl,
    ],
];

include 'includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <?php spoon_breadcrumbs([
            ['name' => 'Главная', 'href' => 'index.php'],
            ['name' => 'Каталог товаров', 'href' => 'catalog.php'],
            ['name' => $productTitle, 'url' => $canonicalUrl],
        ]); ?>
        <h1><?= spoon_h($productTitle) ?></h1>
    </div>
</section>

<section class="page-section light">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="product-gallery">
                    <a class="product-main" href="<?= spoon_h($mainPhoto['src']) ?>" target="_blank" rel="noopener">
                        <img id="productPhoto" src="<?= spoon_h($mainPhoto['src']) ?>"
                             <?php if ($mainPhoto['w'] && $mainPhoto['h']): ?>width="<?= (int)$mainPhoto['w'] ?>" height="<?= (int)$mainPhoto['h'] ?>"<?php endif; ?>
                             alt="<?= spoon_h($productTitle) ?>"/>
                    </a>
                    <?php if (count($photos) > 1): ?>
                        <div class="product-thumbs">
                            <?php foreach ($photos as $index => $photo): ?>
                                <a href="<?= spoon_h($photo['src']) ?>"
                                   class="<?= $index === 0 ? 'act' : '' ?>"
                                   data-w="<?= (int)$photo['w'] ?>"
                                   data-h="<?= (int)$photo['h'] ?>">
                                    <img src="<?= spoon_h($photo['src']) ?>" width="78" height="78"
                                         alt="<?= spoon_h($productTitle) ?> — фото <?= $index + 1 ?>"/>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="product-summary">
                    <div class="product-price">от <span><?= spoon_h($price) ?></span> руб.*</div>
                    <p class="product-note">* Цена действует на крупные оптовые заказы</p>

                    <?php if (empty($product['noSkid'])): ?>
                        <div class="product-benefits">
                            <p>Скидки при заказе от <strong>500</strong> изделий</p>
                            <p>От <strong>1000</strong> изделий — доставка бесплатно</p>
                        </div>
                    <?php endif; ?>

                    <div class="product-actions">
                        <button type="button" class="btn mybtn" onclick="callBack()">Заказать звонок</button>
                        <a class="btn mybtn" href="catalog.php">Все товары</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if (trim((string)($product['description'] ?? '')) !== ''): ?>
    <section class="page-section">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <h2 class="page-heading dark">Описание</h2>
                    <div class="product-description">
                        <?= $product['description'] ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<section class="page-section light product-related">
    <div class="container">
        <h2 class="page-heading dark">Другие товары</h2>
        <div class="goods-list row">
            <?php spoon_render_goods($isCutlery ? 'c6' : 'c1', $product['id'], 3); ?>
        </div>
    </div>
</section>

<script>
    (function () {
        var main = document.getElementById('productPhoto');
        var thumbs = document.querySelectorAll('.product-thumbs a');
        if (!main || !thumbs.length) return;

        Array.prototype.forEach.call(thumbs, function (thumb) {
            thumb.addEventListener('click', function (event) {
                event.preventDefault();
                main.src = thumb.getAttribute('href');
                if (thumb.dataset.w && thumb.dataset.h) {
                    main.setAttribute('width', thumb.dataset.w);
                    main.setAttribute('height', thumb.dataset.h);
                }
                Array.prototype.forEach.call(thumbs, function (item) {
                    item.classList.remove('act');
                });
                thumb.classList.add('act');
            });
        });
    })();
</script>

<script type="application/ld+json"><?= spoon_json_ld($productSchema) ?></script>

<?php include 'includes/footer.php'; ?>
