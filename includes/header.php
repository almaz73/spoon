<?php
if (!isset($pageTitle)) {
    $pageTitle = 'Сувенирная продукция с гравировкой оптом — компания «Ложкин Дом»';
}
if (!isset($pageDescription)) {
    $pageDescription = 'Оптово-производственная компания «Ложкин Дом»: именные ложки, столовые приборы, фляжки и брелоки с гравировкой по закупочным ценам. Доставка по России и СНГ.';
}

$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'xn----htbeijemffg.xn--p1ai';
$canonicalPath = strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
$canonical = $scheme . '://' . $host . $canonicalPath;
$currentPage = basename($_SERVER['PHP_SELF']);

$navItems = [
    'index.php' => 'Главная',
    'why.php' => 'Почему мы',
    'catalog.php' => 'Каталог товаров',
    'reviews.php' => 'Отзывы покупателей',
    'certificates.php' => 'Сертификаты',
];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
    <link rel="canonical" href="<?= htmlspecialchars($canonical) ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Ложкин Дом">
    <meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta property="og:url" content="<?= htmlspecialchars($canonical) ?>">
    <meta property="og:image" content="<?= htmlspecialchars($scheme . '://' . $host . '/images/logo.png') ?>">
    <meta name="yandex-verification" content="a3e95026d5b1e42c"/>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
    <link href="css/carousel.css" rel="stylesheet" type="text/css"/>
    <link href="css/lightbox.css" rel="stylesheet" type="text/css"/>
    <link href="css/animate.min.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function(m,e,t,r,i,k,a){
        m[i]=m[i]function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();
        for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
        k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)
    })(window, document,'script','https://mc.yandex.ru/metrika/tag.js', 'ym');

    ym(98517823, 'init', {clickmap:true, referrer: document.referrer, url: location.href, accurateTrackBounce:true, trackLinks:true});
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/98517823" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<nav class="navbar topmenu navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <span class="sr-only">Меню</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="index.php"><img class="navbar-brand" src="images/logo.png" alt="Ложкин Дом — сувениры с гравировкой"/></a>
        </div>

        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav mynav navbar-nav">
                <?php foreach ($navItems as $file => $label): ?>
                    <li<?= $currentPage === $file ? ' class="active"' : '' ?>><a href="<?= $file ?>"><?= $label ?></a></li>
                <?php endforeach; ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a id="call-me" style="float:right" onclick="callBack()" href="#"><p class="call-text">Заказ
                            звонка</p>+7(952)042-56-27</a></li>
            </ul>
        </div>
    </div>
</nav>
