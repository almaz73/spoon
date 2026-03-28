<?php
$username = "носов";
$password = "носов";
$nonsense = "f07854328kazan27032026fag584ghf63h264yh245h5y";
if (isset($_COOKIE['PrivatePageLogin'])) {
    if ($_COOKIE['PrivatePageLogin'] == md5($password . $nonsense)) {
        ?>

      <!DOCTYPE html>
      <html>
      <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
        <meta name='robots' content='noindex'>
      </head>
      <body>

      <section id="catalog">
        <div class="container">
          <div class="row">
            <h3 style="background: pink; padding: 30px">(Админка) Столовые приборы с гравировкой
              <br>
              <button onclick="createFile()">✍ Сохранить</button>
              <button onclick="location.reload()"> ❌ Отменить изменения</button>
            </h3>
          </div>
          <div class="goods-list row" id="c6"></div>
          <div class="row">
            <h3>Другие сувениры</h3>
          </div>
          <div class="goods-list row" id="c1"></div>
        </div>
      </section>


      <!-- HTML-код модального окна ЗАКАЗА -->
      <div id="tovar" class="modal fade">
        <div class="modal-dialog">

          <div class="container-fluid modal-content" style="border: 3px solid #61a706;">
            <!-- Заголовок модального окна -->
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
                    <div class="gal-slider clr">
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
            <div class="row" style="margin-bottom: 15px; position:relative">
              <div style="position: absolute; z-index: 1; left: 20px">
                <input type="checkbox" id="idSkid">
                <label for="idSkid" style="cursor: pointer; color:#337ab7">
                  Скрыто
                </label>
              </div>
              <div class="col-md-6">
                <div class="skid-fields">
                  <h4 class="label-bg">
                    <strong>Скидочная система</strong>
                    <br>
                    при заказе
                  </h4>
                  <div class="skid">
                    <p>от <strong>5т.р.</strong> - скидка <strong>5%</strong></p>
                    <p>от <strong>30т.р.</strong> - скидка <strong>10%</strong></p>
                    <p>от <strong>70т.р.</strong> - скидка <strong>15%</strong></p>
                    <p>от <strong>100т.р.</strong> - <strong>договорная</strong></p>
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
                      <!--                <input type="hidden" id="utm_source" value="-->
                        <?php //echo $_GET['utm_source'];?><!--">-->
                      <!--                <input type="hidden" id="utm_medium" value="-->
                        <?php //echo $_GET['utm_medium'];?><!--">-->
                      <!--                <input type="hidden" id="utm_campaign" value="-->
                        <?php //echo $_GET['utm_campaign'];?><!--">-->
                      <!--                <input type="hidden" id="utm_term" value="-->
                        <?php //echo $_GET['utm_term'];?><!--">-->
                      <!--                <input type="hidden" id="utm_content" value="-->
                        <?php //echo $_GET['utm_content'];?><!--">-->
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
                   class="img-circle img-responsive" src="images/manager.jpg"/>
              <div class="form-group">
                <input type="text" class="form-control" id="NameCB" name="name" placeholder="Как Вас зовут?">
              </div>
              <div class="form-group">
                <input type="tel" id="PhoneCB" name="phone" class="form-control" placeholder="Ваш номер телефона?">
              </div>
              <div class="form-group">
                <input type="email" id="EmailCB" name="email" class="form-control" placeholder="Ваш e-mail?">
              </div>
              <input type="hidden" id="utm_source" value="<?php echo $_GET['utm_source']; ?>">
              <input type="hidden" id="utm_medium" value="<?php echo $_GET['utm_medium']; ?>">
              <input type="hidden" id="utm_campaign" value="<?php echo $_GET['utm_campaign']; ?>">
              <input type="hidden" id="utm_term" value="<?php echo $_GET['utm_term']; ?>">
              <input type="hidden" id="utm_content" value="<?php echo $_GET['utm_content']; ?>">
              <button style="display: block; width: 100%;" onclick="sendToEmail()" type="submit"
                      class="btn btn-success">Перезвоните мне
              </button>
            </div>
          </div>
        </div>
      </div>


      <link href="css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
      <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
      <link href="css/style.css" rel="stylesheet" type="text/css"/>
      <link href="css/carousel.css" rel="stylesheet" type="text/css"/>
      <link href="css/lightbox.css" rel="stylesheet" type="text/css"/>
      <link href="css/animate.min.css" rel="stylesheet" type="text/css"/>
      <link href="css/admin.css" rel="stylesheet" type="text/css"/>

      <script src="js/jquery-latest.min.js" type="text/javascript"></script>
      <script src="js/bootstrap.js" type="text/javascript"></script>
      <script src="js/adminMethods.js" type="text/javascript"></script>
      <script src="datas/listTovar.js?v=<?php echo filemtime('datas/listTovar.js'); ?>" type="text/javascript"></script>
      <script src="js/admin.js" type="text/javascript"></script>
      <script src="js/mail.js" type="text/javascript"></script>
      <script src="js/lightbox.js" type="text/javascript"></script>

      <dialog id="my-dialog">
        <p>Выберите фото:</p>
        <div class="dialog-closer" onclick="this.closest('dialog').close()">✖</div>
        <p id="dialog-photo"></p>
        <p id="dialog-content"></p>
        <button onclick="setPhoto()"> Разместить</button>
        <button onclick="uploadPhoto()">Загрузить</button>
        <button onclick="deletePhoto()">Удалить</button>
      </dialog>

      </body>
      </html>

        <?php
        exit;
    } else {
        echo "Bad Cookie.";
        exit;
    }
}
if (isset($_GET['p']) && $_GET['p'] == "login") {
    if ($_POST['user'] != $username) {
        echo "Sorry, that username does not match.";
        exit;
    } else if ($_POST['keypass'] != $password) {
        echo "Sorry, that password does not match.";
        exit;
    } else if ($_POST['user'] == $username && $_POST['keypass'] == $password) {
        // Устанавливаем cookie на 10 минут (600 секунд)
//        $expire_time = time() + 60; // 1 минут
        setcookie('PrivatePageLogin', md5($_POST['keypass'] . $nonsense), 0);
        header("Location: $_SERVER[PHP_SELF]");
    } else {
        echo "Sorry, you could not be logged in at this time.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title></title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
  <link href="css/admin.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="login-container">
  <div class="form-header">
    <h2>Добро пожаловать</h2>
    <p>Войдите, используя свои данные</p>
  </div>

  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?p=login'); ?>" method="post">
    <div class="input-group">
      <label for="user">Логин</label>
      <input type="text" name="user" id="user" placeholder="Введите ваш логин" autocomplete="username" required>
    </div>

    <div class="input-group">
      <label for="keypass">Пароль</label>
      <input type="password" name="keypass" id="keypass" placeholder="Введите пароль" autocomplete="current-password"
             required>
    </div>

    <button type="submit" id="submit" class="login-btn">Войти</button>

  </form>
  <div class="form-header">
    <p>Чтобы "забыть" авторизацию на этом устройстве нужно закрыть браузер</p>
  </div>
</div>


</body>
</html>