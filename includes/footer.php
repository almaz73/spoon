<?php
$utm = static function (string $key): string {
    return htmlspecialchars($_GET[$key] ?? '', ENT_QUOTES);
};
?>
<section id="event" class="container">
    <div class="text-left" id="lead" title="Оставить заявку">
        <img style="cursor: pointer;" src="images/lead.png" width="63" height="63" onclick="callBack()" alt="Оставить заявку"/>
        <div class="blead animated fadeInLeft" onclick="callBack()">Оставить заявку</div>
    </div>
</section>

<footer id="footer">
    <div class="container">
        <div class="row center">
            <div class="col-md-6 text-left"><strong>Email: lojkin.dom@mail.ru</strong></div>
            <div class="col-md-6 text-right"><strong>Телефон/WhatsApp/Viber: +7(952)042-56-27</strong></div>
        </div>
        <div class="row center footer-links">
            <?php foreach ($navItems as $file => $label): ?>
                <a href="<?= $file ?>"><?= $label ?></a>
            <?php endforeach; ?>
        </div>
    </div>
</footer>

<!-- HTML-код модального окна ЗАКАЗА -->
<div id="tovar" class="modal fade">
    <div class="modal-dialog">

        <div class="container-fluid modal-content" style="border: 3px solid #61a706;"><!-- Заголовок модального окна -->
            <div class="row modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 id="modelF1" class="modal-title">Заголовок модального окна</h4>
            </div>
            <!-- Основное содержимое модального окна -->
            <div class="row modal-body">
                <div class="col-sm-12 col-md-6">
                    <div class="gal-cont">
                        <div class="arrows gal-left left-arrow"><span class="glyphicon glyphicon-chevron-left"
                                                                      aria-hidden="true"></span></div>
                        <div class="arrows gal-right right-arrow"><span
                                class="glyphicon glyphicon glyphicon-chevron-right" aria-hidden="true"></span></div>
                        <div class="gal-image">
                            <img src="#" alt="" title="">
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="row gal-thumbs-cont">
                        <div class="gal-thumbs">
                            <div class="gal-slider">
                                <a href="#">
                                    <img src="#" alt="" title="">
                                </a>
                            </div>
                        </div>
                    </div>
                    <section class="b-selection-model">
                        <p class="model-descr">
                        </p>
                        <!--<p class="model-price"><span class="price promo-txt"></span> <span class="ruble">&#8381;</span> </p>-->
                    </section>
                </div>
            </div>
            <div class="row" style="margin-bottom: 15px;">
                <div class="col-md-6">
                    <div class="skid-fields">
                        <h4 class="label-bg">
                            <strong>Скидочная система</strong>
                            <br>
                            при заказе
                        </h4>
                        <div class="skid">
                            <p>Скидки от <strong>500</strong> изделий</p>
                            <p>от <strong>1000</strong> изделий доставка бесплатно</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <section class="b-mod-form" id="mobile-hide">
                        <div class="order-form mod">
                            <fieldset>
                                <label class="label-bg text-center">Получить полный прайс лист <br>и форму заявки для
                                    заказа</label>
                                <div class="form-group-sm">
                                    <input type="text" class="form-control" id="NameF1" name="name"
                                           placeholder="Как Вас зовут?">
                                </div>
                                <div class="form-group-sm">
                                    <input type="tel" id="PhoneF1" name="phone" class="form-control"
                                           placeholder="Ваш номер телефона?">
                                </div>
                                <div class="form-group-sm">
                                    <input type="email" id="EmailF1" name="email" class="form-control"
                                           placeholder="Ваш e-mail?">
                                </div>
                                <button style="width: 100%" onclick="sendpriceF1()" type="submit"
                                        class="btn btn-primary">Получить полный каталог продукции
                                </button>
                            </fieldset>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- HTML-код модального окна ОБРАТНЫЙ ЗВОНОК -->
<div id="call-back" class="modal fade">
    <div class="modal-dialog">
        <div class="container-fluid modal-content" style="border: 3px solid #61a706;max-width: 450px;">
            <!-- Заголовок модального окна -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 id="modelCB">Заказ консультации по телефону</h4>
            </div>
            <!-- Основное содержимое модального окна -->
            <div class="modal-body">
                <img style="width: 45%;margin: auto; margin-bottom: 15px; border: 3px solid #61a706"
                     class="img-circle img-responsive" src="images/manager.jpg" alt="Менеджер Ложкин Дом"/>
                <div class="form-group">
                    <input type="text" class="form-control" id="NameCB" name="name" placeholder="Как Вас зовут?">
                </div>
                <div class="form-group">
                    <input type="tel" id="PhoneCB" name="phone" class="form-control" placeholder="Ваш номер телефона?">
                </div>
                <div class="form-group">
                    <input type="email" id="EmailCB" name="email" class="form-control" placeholder="Ваш e-mail?">
                </div>
                <input type="hidden" id="utm_source" value="<?= $utm('utm_source') ?>">
                <input type="hidden" id="utm_medium" value="<?= $utm('utm_medium') ?>">
                <input type="hidden" id="utm_campaign" value="<?= $utm('utm_campaign') ?>">
                <input type="hidden" id="utm_term" value="<?= $utm('utm_term') ?>">
                <input type="hidden" id="utm_content" value="<?= $utm('utm_content') ?>">
                <button style="display: block; width: 100%;" onclick="sendToEmail()" type="submit"
                        class="btn btn-success">Перезвоните мне
                </button>
            </div>
        </div>
    </div>
</div>
<!-- HTML-код модального окна БЛАГОДАРНОСТЬ -->
<div id="thanks" class="modal fade">
    <div class="modal-dialog">
        <div class="container-fluid modal-content" style="border: 3px solid #61a706;max-width: 450px;">
            <!-- Заголовок модального окна -->
            <div class="modal-header">
                <h4 id="thanksheader">Спасибо за обращение</h4>
            </div>
            <!-- Основное содержимое модального окна -->
            <div class="modal-body">
                <img style="width: 45%;margin: auto; margin-bottom: 15px; border: 3px solid #61a706"
                     class="img-circle img-responsive" src="images/manager.jpg" alt="Менеджер Ложкин Дом"/>
                <input type="hidden" id="model" name="model" class="model" value="Заказ обратного звонка">
                <h4 style="color:#61a706">Ваше запрос принят и будет обработан в ближайшее время!</h4>
                <button style="display: block; width: 100%;" type="button" onclick="window.location.href = '/'"
                        class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Закрыть
                </button>
            </div>
        </div>
    </div>
</div>

<!-- HTML-код модального окна ОШИБКА -->
<div id="errors" class="modal fade">
    <div class="modal-dialog">
        <div class="container-fluid modal-content" style="border: 3px solid #61a706;max-width: 450px;">
            <!-- Заголовок модального окна -->
            <div class="modal-header">
                <h4 id="errorsheader">Ошибка! Заполните все поля!</h4>
            </div>
            <!-- Основное содержимое модального окна -->
            <div class="modal-body">
                <img style="width: 45%;margin: auto; margin-bottom: 15px; border: 3px solid #61a706"
                     class="img-circle img-responsive" src="images/manager.jpg" alt="Менеджер Ложкин Дом"/>
                <input type="hidden" id="model" name="model" class="model" value="Заказ обратного звонка">
                <h4 style="color:red">Для отправки отзыва требуется заполнить все поля<br>и прекркпить фото в формате
                    jpeg/png</h4>
                <button style="display: block; width: 100%;" type="button" onclick="window.location.href = '/'"
                        class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Закрыть
                </button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">(window.Image ? (new Image()) : document.createElement('img')).src = 'https://vk.com/rtrg?p=VK-RTRG-120587-ffm06';</script>
<!-- Yandex.Metrika counter -->
<script type="text/javascript"> (function (d, w, c) {
    (w[c] = w[c] || []).push(function () {
        try {
            w.yaCounter44781169 = new Ya.Metrika({
                id: 44781169,
                clickmap: true,
                trackLinks: true,
                accurateTrackBounce: true,
                webvisor: true
            });
        } catch (e) {
        }
    });
    var n = d.getElementsByTagName('script')[0], s = d.createElement('script'), f = function () {
        n.parentNode.insertBefore(s, n);
    };
    s.type = 'text/javascript';
    s.async = true;
    s.src = 'https://mc.yandex.ru/metrika/watch.js';
    if (w.opera == '[object Opera]') {
        d.addEventListener('DOMContentLoaded', f, false);
    } else {
        f();
    }
})(document, window, 'yandex_metrika_callbacks'); </script>
<noscript>
    <div><img src="https://mc.yandex.ru/watch/44781169" style="position:absolute; left:-9999px;" alt=""/></div>
</noscript> <!-- /Yandex.Metrika counter -->

<script src="js/jquery-latest.min.js" type="text/javascript"></script>
<script src="js/bootstrap.js" type="text/javascript"></script>
<script src="datas/listTovar.js?v=<?php echo filemtime('datas/listTovar.js'); ?>" type="text/javascript"></script>
<script src="js/lightbox.js" type="text/javascript"></script>
<script src="js/mail.js" type="text/javascript"></script>
<script src="js/catalogue.js" type="text/javascript"></script>
</body>
</html>
