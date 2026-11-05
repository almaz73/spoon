<?php
require __DIR__ . '/datas/goods-data.php';
require __DIR__ . '/datas/reviews-data.php';

$pageTitle = 'Сувенирная продукция с гравировкой оптом — компания «Ложкин Дом»';
$pageDescription = 'Оптово-производственная компания «Ложкин Дом»: именные ложки, столовые приборы, фляжки и брелоки с гравировкой по закупочным ценам. Доставка по России и СНГ.';
include 'includes/header.php';
?>

<section id="1" style="margin-top: 51px;">
    <div class="non-padd container-fluid">
        <div class="non-padd col-md-12">
            <div class="well-none">
                <div id="fgalery">
                    <div id="topCarousel" class="carousel slide">
                        <div class="carousel-inner">
                            <div class="item active">
                                <img src="banners/01.jpg?v=<?php echo filemtime('banners/01.jpg'); ?>" width="1200"
                                     height="485" alt="Ложки с гравировкой имени"/>
                                <div class="carousel-caption">
                                    <h2>Ложки с гравировкой имени</h2>
                                </div>
                            </div>
                            <div class="item">
                                <img src="banners/02.jpg?v=<?php echo filemtime('banners/02.jpg'); ?>" width="1200"
                                     height="485" alt="Гравировка любых изображений и текста"/>
                                <div class="carousel-caption">
                                    <h2>Гравировка любых изображений и текста</h2>
                                </div>
                            </div>
                            <div class="item">
                                <img src="banners/03.jpg?v=<?php echo filemtime('banners/03.jpg'); ?>" width="1200"
                                     height="485" alt="Ложки с гравировкой «Знаки зодиака»"/>
                                <div class="carousel-caption">
                                    <h2>Ложки с гравировкой "Знаки зодиака"</h2>
                                </div>
                            </div>
                            <div class="item">
                                <img src="banners/04.jpg?v=<?php echo filemtime('banners/04.jpg'); ?>" width="1200"
                                     height="485" alt="Ложки с зеркальной гравировкой"/>
                                <div class="carousel-caption">
                                    <h2>Ложки с зеркальной гравировкой</h2>
                                </div>
                            </div>
                        </div>

                        <a class="left carousel-control" href="#topCarousel" data-slide="prev"><span
                                class="glyphicon glyphicon-chevron-left"></span></a>
                        <a class="right carousel-control" href="#topCarousel" data-slide="next"><span
                                class="glyphicon glyphicon-chevron-right"></span></a>
                    </div>
                </div>
            </div>
        </div>
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

<section class="page-section light home-intro">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <h1>Сувенирная продукция с гравировкой оптом</h1>
                <p class="page-lead dark">«Ложкин Дом» — оптово-производственная компания, которая наносит гравировку
                    на столовые приборы, фляжки, брелоки, зеркала и другие сувениры. Мы работаем с магазинами,
                    корпоративными клиентами и частными заказчиками, предлагая закупочные цены и доставку по России и
                    странам СНГ.</p>

            </div>
        </div>
    </div>
</section>

<section id="catalog" class="page-section dark">
    <div class="container">
        <div class="row">
            <h2 class="page-heading">Каталог товаров</h2>
        </div>
        <div class="row">
            <h3 class="page-heading">Столовые приборы с гравировкой</h3>
        </div>
        <div class="goods-list row" id="c6"><?php spoon_render_goods('c6'); ?></div>
        <div class="row">
            <h3 class="page-heading">Другие сувениры</h3>
        </div>
        <div class="goods-list row" id="c1"><?php spoon_render_goods('c1'); ?></div>

    </div>
</section>

<?php spoon_render_reviews(['href' => 'reviews.php', 'label' => 'Все отзывы покупателей']); ?>

<section id="promo" class="page-section">
    <div class="container">
        <h2 class="page-heading">Наши преимущества</h2>
        <div class="row center otst">
            <div class="col-sm-3 col-md-3">
                <p class="promo-txt"><span>Доставка</span> по России и странам СНГ</p>
                <img class="" src="images/im/1.png" width="90" height="90" alt="Доставка по России и странам СНГ"/>
            </div>
            <div class="col-sm-3 col-md-3">
                <p class="promo-txt"><span>Опытная</span> команда специалистов</p>
                <img class="" src="images/im/2.png" width="90" height="90" alt="Опытная команда специалистов"/>
            </div>
            <div class="col-sm-3 col-md-3">
                <p class="promo-txt">Мы ценим <span>каждого</span> заказчика</p>
                <img class="" src="images/im/3.png" width="90" height="90" alt="Мы ценим каждого заказчика"/>
            </div>
            <div class="col-sm-3 col-md-3">
                <p class="promo-txt"><span>Выполняем</span> заказы в поставленные сроки</p>
                <img class="" src="images/im/4.png" width="90" height="90" alt="Выполняем заказы в срок"/>
            </div>
        </div>
        <div class="center"><a class="btn mybtn" href="why.php">Подробнее о компании</a></div>
    </div>
</section>

<section class="page-section dark home-links">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h3><a href="catalog.php">Каталог товаров</a></h3>
                <p>Столовые приборы с гравировкой и другие сувениры с доставкой по России и СНГ.</p>
            </div>
            <div class="col-md-4">
                <h3><a href="reviews.php">Отзывы покупателей</a></h3>
                <p>Что заказчики говорят о качестве изделий, сроках доставки и работе менеджеров.</p>
            </div>
            <div class="col-md-4">
                <h3><a href="certificates.php">Сертификаты</a></h3>
                <p>Сертификаты соответствия на столовые приборы из нержавеющей стали.</p>
            </div>
        </div>
    </div>
</section>

<script>
    // Поддержка старых ссылок с якорями после разделения сайта на страницы
    (function () {
        var anchors = {
            '#promo': 'why.php',
            '#setrificat': 'certificates.php'
        };
        var target = anchors[window.location.hash];
        if (target) window.location.replace(target);
    })();
</script>

<?php include 'includes/footer.php'; ?>
