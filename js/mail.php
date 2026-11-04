<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');

require_once dirname(__DIR__) . '/includes/telegram.php';

$data = [
    'name' => is_string($_POST['name'] ?? null) ? $_POST['name'] : '',
    'phone' => is_string($_POST['phone'] ?? null) ? $_POST['phone'] : '',
    'email' => is_string($_POST['email'] ?? null) ? $_POST['email'] : '',
    'title' => is_string($_POST['title'] ?? null) ? $_POST['title'] : '',
    'city' => is_string($_POST['city'] ?? null) ? $_POST['city'] : '',
    'task' => is_string($_POST['task'] ?? null) ? $_POST['task'] : '',
    'model' => is_string($_POST['model'] ?? null) ? $_POST['model'] : '',
    'utm_source' => is_string($_POST['utm_source'] ?? null) ? $_POST['utm_source'] : '',
    'utm_medium' => is_string($_POST['utm_medium'] ?? null) ? $_POST['utm_medium'] : '',
    'utm_campaign' => is_string($_POST['utm_campaign'] ?? null) ? $_POST['utm_campaign'] : '',
    'utm_term' => is_string($_POST['utm_term'] ?? null) ? $_POST['utm_term'] : '',
    'utm_content' => is_string($_POST['utm_content'] ?? null) ? $_POST['utm_content'] : '',
];

$data['name'] = ucwords(strtolower($data['name']));
$replaceArr = [" ", "(", ")", "-"];
$data['phone'] = str_replace($replaceArr, '', $data['phone']);
$data['phone'] = str_replace('+7', '8', $data['phone']);

$title = htmlspecialchars($data['title'], ENT_QUOTES, 'UTF-8');
$name = htmlspecialchars($data['name'], ENT_QUOTES, 'UTF-8');
$phone = htmlspecialchars($data['phone'], ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($data['email'], ENT_QUOTES, 'UTF-8');
$city = htmlspecialchars($data['city'], ENT_QUOTES, 'UTF-8');
$model = htmlspecialchars($data['model'], ENT_QUOTES, 'UTF-8');

header("Content-type:text/html;charset=utf-8");

$to = 'lih1989@yandex.ru, lojkin.dom@mail.ru, almaz73@gmail.com';
$fromEmail = "php@a1249196.xsph.ru";

$body = "
<b><i>{$title}</i></b><br /><br />

<i>Имя отправителя</i>\t\t : <b>{$name}</b><br />
<i>Контактный телефон</i>\t : <b>{$phone}</b><br />
<i>E-mail</i>\t\t\t\t : <b>{$email}</b><br />
<i>Город</i>\t\t\t\t : <b>{$city}</b><br />
<i>Заказ</i>\t\t\t\t : <b>{$model}</b><br />
";

$headers = 'From: Сайт - Ложкин Дом <' . $fromEmail . '>' . "\r\n";
$headers .= "Content-type: text/html; charset=\"utf-8\"\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

if (function_exists('mail')) {
    mail($to, 'Заявка с сайта Ложкин-Дом', $body, $headers);
}

$message = ':::::::  <b>Заявка с сайта</b>' . "\n";
$message .= 'Имя отправителя: <b>' . $name . '</b>' . "\n";
$message .= 'Контактный телефон: <b>' . $phone . '</b>' . "\n";
$message .= 'E-mail: <b>' . $email . '</b>' . "\n";
$message .= 'Заказ: <b>' . $model . '</b>' . "\n";

spoon_telegram_send($message);
