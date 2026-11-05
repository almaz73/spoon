<?php
require_once __DIR__ . '/site.php';

if (!isset($pageTitle)) {
    $pageTitle = 'Сувенирная продукция с гравировкой оптом — компания «Ложкин Дом»';
}
if (!isset($pageDescription)) {
    $pageDescription = 'Оптово-производственная компания «Ложкин Дом»: именные ложки, столовые приборы, фляжки и брелоки с гравировкой по закупочным ценам. Доставка по России и СНГ.';
}

$currentPage = $currentPage ?? basename($_SERVER['PHP_SELF']);
$canonical = $currentPage === 'index.php' ? spoon_site_url() : spoon_current_url();
$ogType = $ogType ?? 'website';
$ogImage = $pageImage ?? (spoon_site_url() . 'images/logo.png');

$navItems = [
    'index.php' => 'Главная',
    'why.php' => 'Почему мы',
    'catalog.php' => 'Каталог товаров',
    'reviews.php' => 'Отзывы покупателей',
    'certificates.php' => 'Сертификаты',
];

$websiteSchema = [
    '@type' => 'WebSite',
    '@id' => spoon_site_url() . '#website',
    'name' => 'Ложкин Дом',
    'url' => spoon_site_url(),
    'inLanguage' => 'ru-RU',
    'publisher' => ['@id' => spoon_site_url() . '#organization'],
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
    <meta property="og:type" content="<?= htmlspecialchars($ogType) ?>">
    <meta property="og:site_name" content="Ложкин Дом">
    <meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta property="og:url" content="<?= htmlspecialchars($canonical) ?>">
    <meta property="og:image" content="<?= htmlspecialchars($ogImage) ?>">
    <?php if (!empty($pageRobots)): ?>
        <meta name="robots" content="<?= htmlspecialchars($pageRobots) ?>">
    <?php endif; ?>
    <meta name="yandex-verification" content="a3e95026d5b1e42c"/>
    <script type="application/ld+json"><?= spoon_json_ld([
        '@context' => 'https://schema.org',
        '@graph' => [spoon_organization_schema(), $websiteSchema],
    ]) ?></script>
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
            <a href="index.php"><img class="navbar-brand" src="images/logo.png" width="300" height="72"
                                     alt="Ложкин Дом — сувениры с гравировкой"/></a>
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
