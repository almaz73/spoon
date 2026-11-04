<?php
$pageTitle = 'Отзывы покупателей о продукции «Ложкин Дом»';
$pageDescription = 'Отзывы заказчиков «Ложкин Дом» из Челябинска, Астаны, Норильска и Краснодара о качестве сувениров с гравировкой, скорости доставки и работе менеджеров.';
$pageReviews = [
    [
        'author' => 'Елена Никольская',
        'city' => 'Челябинск',
        'text' => 'Заказ сделала на прошлой неделе. Менеджер попался вежливый, понятливый. Очень быстро перезвонил и уже через час мы утрясли все детали заказа. Я из Челябинска, заказ доставили за 2 дня - пока всё отлично.',
    ],
    [
        'author' => 'Оразгуль Ахметова',
        'city' => 'Астана',
        'text' => 'Ух ты! Ложечки классные!! Спасибо менеджеру Насте. Я сначала и не думала о ложечках, но она уговорила, быстро всё сделала и отправила, для меня положила небольшой подарок. Мелочь, а приятно. Буду заказывать ещё!!!',
    ],
    [
        'author' => 'Сергей Кирилов',
        'city' => 'Норильск',
        'text' => 'Компания молодая, но работают оперативно. Вчера сделал небольшой заказ, а сегодня уже отправили. Качество шикарное я доволен. Заказываю третий раз, надеюсь на дополнительную скидку.',
    ],
    [
        'author' => 'Евгений Попов',
        'city' => 'Краснодар',
        'text' => 'До вас работал с другими компаниями, занимаюсь торговлей не первый год. Так вот у вас качество намного выше. Если бы вы ещё и монеты делали... Большое спасибо.',
    ],
];
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

<section id="otziv" class="page-section light">
    <h2 class="page-heading dark">Отзывы заказчиков</h2>
    <div class="container" style="text-align: -webkit-center;">
        <div class="row ot_row">
            <div class="col-md-6 col-sm-6">
                <div class="">
                    <div class="row">
                        <div class="col-md-3"><img class="img-responsive" src="images/otz/client_01.jpg" width="100" height="100" alt="Елена Никольская"/></div>
                        <div class="col-md-9">
                            <div class="ot_name"><strong>Елена Никольская</strong></div>
                            <div class="ot_text">
                                Заказ сделала на прошлой неделе. Менеджер попался вежливый, понятливый. Очень быстро
                                перезвонил и уже через час мы утрясли все детали заказа. Я из Челябинска, заказ
                                доставили за 2 дня - пока всё отлично.
                            </div>
                            <div style="text-align:right;font-style: italic;margin-right: 5%;" class="ot_name"><strong>г.
                                Челябинск</strong></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="">
                    <div class="row">
                        <div class="col-md-3"><img class="img-responsive" src="images/otz/client_02.jpg" width="100" height="100" alt="Оразгуль Ахметова"/></div>
                        <div class="col-md-9">
                            <div class="ot_name"><strong>Оразгуль Ахметова</strong></div>
                            <div class="ot_text">
                                Ух ты! Ложечки классные!! Спасибо менеджеру Насте. Я сначала и не думала о ложечках, но
                                она уговорила, быстро всё сделала и отправила, для меня положила небольшой подарок.
                                Мелочь, а приятно. Буду заказывать ещё!!!
                            </div>
                            <div style="text-align:right;font-style: italic;margin-right: 5%;" class="ot_name"><strong>г.
                                Астана</strong></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row ot_row">
            <div class="col-md-6 col-sm-6">
                <div class="">
                    <div class="row">
                        <div class="col-md-3"><img class="img-responsive" src="images/otz/client_03.jpg" width="100" height="100" alt="Сергей Кирилов"/></div>
                        <div class="col-md-9">
                            <div class="ot_name"><strong>Сергей Кирилов</strong></div>
                            <div class="ot_text">
                                Компания молодая, но работают оперативно. Вчера сделал небольшой заказ, а сегодня уже
                                отправили. Качество шикарное я доволен. Заказываю третий раз, надеюсь на дополнительную
                                скидку.
                            </div>
                            <div style="text-align:right;font-style: italic;margin-right: 5%;" class="ot_name"><strong>г.
                                Норильск</strong></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="">
                    <div class="row">
                        <div class="col-md-3"><img class="img-responsive" src="images/otz/client_04.jpg" width="100" height="100" alt="Евгений Попов"/></div>
                        <div class="col-md-9">
                            <div class="ot_name"><strong>Евгений Попов</strong></div>
                            <div class="ot_text">
                                До вас работал с другими компаниями, занимаюсь торговлей не первый год. Так вот у вас
                                качество намного выше. Если бы вы ещё и монеты делали... Большое спасибо.
                            </div>
                            <div style="text-align:right;font-style: italic;margin-right: 5%;" class="ot_name"><strong>г.
                                Краснодар</strong></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p class="center"><a class="btn mybtn" href="catalog.php">Перейти в каталог товаров</a></p>
    </div>
</section>

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
