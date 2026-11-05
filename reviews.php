<?php
require __DIR__ . '/datas/reviews-data.php';

$pageTitle = 'Отзывы покупателей о продукции «Ложкин Дом»';
$pageDescription = 'Отзывы заказчиков «Ложкин Дом» из Челябинска, Астаны, Норильска и Краснодара о качестве сувениров с гравировкой, скорости доставки и работе менеджеров.';
$pageReviews = spoon_reviews();
include 'includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <?php spoon_breadcrumbs([
            ['name' => 'Главная', 'href' => 'index.php'],
            ['name' => 'Отзывы покупателей'],
        ]); ?>
        <h1>Отзывы покупателей</h1>
        <p class="page-lead">Мы дорожим доверием каждого заказчика. Здесь собраны отзывы клиентов о качестве
            сувениров с гравировкой, сроках доставки и работе нашей команды.</p>
    </div>
</section>

<?php spoon_render_reviews(['href' => 'catalog.php', 'label' => 'Перейти в каталог товаров']); ?>

<?php
$reviewSchemaItems = [];
foreach ($pageReviews as $review) {
    $reviewSchemaItems[] = [
        '@type' => 'Review',
        'author' => ['@type' => 'Person', 'name' => $review['author']],
        'reviewBody' => $review['text'],
        'inLanguage' => 'ru-RU',
        'locationCreated' => ['@type' => 'Place', 'name' => 'г. ' . $review['city']],
        'itemReviewed' => ['@id' => spoon_site_url() . '#organization'],
    ];
}
?>
<script type="application/ld+json"><?= spoon_json_ld([
    '@context' => 'https://schema.org',
    '@type' => 'Organization',
    '@id' => spoon_site_url() . '#organization',
    'name' => 'Ложкин Дом',
    'url' => spoon_site_url(),
    'review' => $reviewSchemaItems,
]) ?></script>

<?php include 'includes/footer.php'; ?>
