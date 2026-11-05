<?php
require_once dirname(__DIR__) . '/includes/site.php';

function spoon_reviews(): array
{
    return [
        [
            'author' => 'Елена Никольская',
            'city' => 'Челябинск',
            'photo' => 'images/otz/client_01.jpg',
            'text' => 'Заказ сделала на прошлой неделе. Менеджер попался вежливый, понятливый. Очень быстро перезвонил и уже через час мы утрясли все детали заказа. Я из Челябинска, заказ доставили за 2 дня - пока всё отлично.',
        ],
        [
            'author' => 'Оразгуль Ахметова',
            'city' => 'Астана',
            'photo' => 'images/otz/client_02.jpg',
            'text' => 'Ух ты! Ложечки классные!! Спасибо менеджеру Насте. Я сначала и не думала о ложечках, но она уговорила, быстро всё сделала и отправила, для меня положила небольшой подарок. Мелочь, а приятно. Буду заказывать ещё!!!',
        ],
        [
            'author' => 'Сергей Кирилов',
            'city' => 'Норильск',
            'photo' => 'images/otz/client_03.jpg',
            'text' => 'Компания молодая, но работают оперативно. Вчера сделал небольшой заказ, а сегодня уже отправили. Качество шикарное я доволен. Заказываю третий раз, надеюсь на дополнительную скидку.',
        ],
        [
            'author' => 'Евгений Попов',
            'city' => 'Краснодар',
            'photo' => 'images/otz/client_04.jpg',
            'text' => 'До вас работал с другими компаниями, занимаюсь торговлей не первый год. Так вот у вас качество намного выше. Если бы вы ещё и монеты делали... Большое спасибо.',
        ],
    ];
}

function spoon_render_reviews(?array $cta = null): void
{
    ?>
    <section id="otziv" class="page-section light">
        <h2 class="page-heading dark">Отзывы заказчиков</h2>
        <div class="container" style="text-align: -webkit-center;">
            <?php foreach (array_chunk(spoon_reviews(), 2) as $chunk): ?>
                <div class="row ot_row">
                    <?php foreach ($chunk as $review): ?>
                        <div class="col-md-6 col-sm-6">
                            <div class="">
                                <div class="row">
                                    <div class="col-md-3"><img class="img-responsive"
                                                              src="<?= spoon_h($review['photo']) ?>" width="100"
                                                              height="100"
                                                              alt="<?= spoon_h($review['author']) ?>"/></div>
                                    <div class="col-md-9">
                                        <div class="ot_name"><strong><?= spoon_h($review['author']) ?></strong></div>
                                        <div class="ot_text"><?= spoon_h($review['text']) ?></div>
                                        <div style="text-align:right;font-style: italic;margin-right: 5%;"
                                             class="ot_name"><strong>г. <?= spoon_h($review['city']) ?></strong></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
            <?php if ($cta !== null ): ?>
                <p class="center"><a class="btn mybtn"
                                     href="<?= spoon_h($cta['href']) ?>"><?= spoon_h($cta['label']) ?></a></p>
            <?php endif; ?>
        </div>
    </section>
    <?php
}
