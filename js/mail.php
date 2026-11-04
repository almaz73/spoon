<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');

require_once dirname(__DIR__) . '/includes/telegram.php';
require_once dirname(__DIR__) . '/includes/request-guard.php';

function mail_response(array $payload, int $status = 200): void
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    header('X-Content-Type-Options: nosniff');
    header('Cache-Control: no-store');
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    exit;
}

function mail_field(string $key, int $maxLength): string
{
    $value = $_POST[$key] ?? '';
    if (!is_string($value)) {
        return '';
    }

    $value = trim((string)preg_replace('/[\x00-\x1F\x7F]+/u', ' ', $value));

    return function_exists('mb_substr') ? mb_substr($value, 0, $maxLength, 'UTF-8') : substr($value, 0, $maxLength);
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    mail_response(['success' => false, 'error' => 'Метод не поддерживается'], 405);
}

if (!spoon_request_is_same_origin()) {
    mail_response(['success' => false, 'error' => 'Запрос отклонён'], 403);
}

if (!spoon_rate_limit_allow('lead:' . spoon_request_ip(), 5, 900)) {
    mail_response(['success' => false, 'error' => 'Слишком много заявок. Повторите позже.'], 429);
}

$data = [
    'name' => mail_field('name', 100),
    'phone' => mail_field('phone', 40),
    'email' => mail_field('email', 150),
    'title' => mail_field('title', 200),
    'city' => mail_field('city', 100),
    'task' => mail_field('task', 200),
    'model' => mail_field('model', 200),
    'utm_source' => mail_field('utm_source', 200),
    'utm_medium' => mail_field('utm_medium', 200),
    'utm_campaign' => mail_field('utm_campaign', 200),
    'utm_term' => mail_field('utm_term', 200),
    'utm_content' => mail_field('utm_content', 200),
];

if ($data['name'] === '' || $data['phone'] === ''
    || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    mail_response(['success' => false, 'error' => 'Заполните имя, телефон и корректный e-mail'], 422);
}

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

if (function_exists('mail') && !mail($to, 'Заявка с сайта Ложкин-Дом', $body, $headers)) {
    error_log('mail.php: не удалось отправить письмо');
}

$message = ':::::::  <b>Заявка с сайта</b>' . "\n";
$message .= 'Имя отправителя: <b>' . $name . '</b>' . "\n";
$message .= 'Контактный телефон: <b>' . $phone . '</b>' . "\n";
$message .= 'E-mail: <b>' . $email . '</b>' . "\n";
$message .= 'Заказ: <b>' . $model . '</b>' . "\n";

spoon_telegram_send($message);

mail_response(['success' => true]);
