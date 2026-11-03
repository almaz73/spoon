<?php
$pageTitle = 'Сертификаты на столовые приборы с гравировкой — «Ложкин Дом»';
$pageDescription = 'Сертификаты соответствия на столовые приборы «Ложкин Дом» из нержавеющей стали. Открывайте документы в полном размере и убедитесь в качестве продукции.';
include 'includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <h1>Сертификаты</h1>
        <p class="page-lead">Наша продукция соответствует требованиям качества. Нажмите на изображение, чтобы открыть
            сертификат в полном размере.</p>
    </div>
</section>

<section id="setrificat" class="page-section dark">
    <h2 class="page-heading">Наши ложки сертифицированы</h2>
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4 col-sm-4">
                <a href="images/sertific/s0.jpeg" target="_blank" rel="noopener">
                    <img class="" src="images/sertific/t0.jpg" title="Открыть сертификат" alt="Сертификат соответствия 1"/>
                </a></div>
            <div class="col-md-4 col-sm-4">
                <a href="images/sertific/s1.jpeg" target="_blank" rel="noopener">
                    <img class="" src="images/sertific/t1.jpg" title="Открыть сертификат" alt="Сертификат соответствия 2"/>
                </a>
            </div>
            <div class="col-md-4 col-sm-4">
                <a href="images/sertific/s2.jpeg" target="_blank" rel="noopener">
                    <img class="" src="images/sertific/t2.jpg" title="Открыть сертификат" alt="Сертификат соответствия 3"/>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <p class="page-text">Столовые приборы изготовлены из нержавеющей стали на Павловском заводе
                    художественных металлоизделий и имеют сертификаты соответствия. Гравировка выполняется без
                    повреждения защитного покрытия изделий.</p>
            </div>
        </div>
    </div>
</section>

<section class="page-section light">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 center">
                <h2 class="page-heading dark">Остались вопросы по качеству?</h2>
                <p class="page-text">Свяжитесь с нами — расскажем о материалах, сертификатах и условиях оптовых
                    заказов.</p>
                <p>
                    <a class="btn mybtn" onclick="callBack()" href="#">Заказать звонок</a>
                    <a class="btn mybtn" href="catalog.php">Перейти в каталог</a>
                </p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
