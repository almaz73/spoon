<?php

$data = array(
    'name' => isset($_POST['name']) ? $_POST['name'] : '',
    'phone' => isset($_POST['phone']) ? $_POST['phone'] : '',
    'email' => isset($_POST['email']) ? $_POST['email'] : '',
    'title' => isset($_POST['title']) ? $_POST['title'] : '',
    'city' => isset($_POST['city']) ? $_POST['city'] : '',
    'task' => isset($_POST['task']) ? $_POST['task'] : '',
    'model' => isset($_POST['model']) ? $_POST['model'] : '',
    'utm_source' => isset($_POST['utm_source']) ? $_POST['utm_source'] : '',
    'utm_medium' => isset($_POST['utm_medium']) ? $_POST['utm_medium'] : '',
    'utm_campaign' => isset($_POST['utm_campaign']) ? $_POST['utm_campaign'] : '',
    'utm_term' => isset($_POST['utm_term']) ? $_POST['utm_term'] : '',
    'utm_content' => isset($_POST['utm_content']) ? $_POST['utm_content'] : ''
);

$data['name'] = ucwords(strtolower($data['name']));
$replaceArr = array(" ", "(", ")", "-");
$data['phone'] = str_replace($replaceArr, '', $data['phone']);
$data['phone'] = str_replace('+7', '8', $data['phone']);


header("Content-type:text/html;charset=utf-8");

//$to  = 'lih1989@yandex.ru, lojkin.dom@mail.ru';
$to = 'almaz73@yandex.ru, almaz73@gmail.com';

$Subject = $data['title'] || 'Заявка с сайта';

$email = "
<b><i>" . $data['title'] . "</i></b><br /><br />

<i>Имя отправителя</i>\t\t : <b>" . $data['name'] . "</b><br />
<i>Контактный телефон</i>\t : <b>" . $data['phone'] . "</b><br />
<i>E-mail</i>\t\t\t\t : <b>" . $data['email'] . "</b><br />
<i>Город</i>\t\t\t\t : <b>" . $data['city'] . "</b><br />
<i>Заказ</i>\t\t\t\t : <b>" . $data['model'] . "</b><br />


";
//Usean email address that matches your hosting domain
$fromEmail = "php@a1249196.xsph.ru";  // Changed from php@ложкин-дом.рф
$headers = 'From: Сайт - Ложкин Дом <' . $fromEmail . '>' . "\r\n";
$headers .= "Content-type: text/html; charset=\"utf-8\"\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// Check if the server can send emails
if (!function_exists('mail')) {
    die('PHP mail() function is not availableon this server');
}

// Try sending the email
mail($to, 'Заявка с сайта Ложкин-Дом', $email, $headers);



// повторяем в телеграм

$token = 'bot8235288635:AAF_soJaYR8OPHAQrpfcF4FDUr2JjRRDlVw';
$chatID = '-5064627941';

// ложки
//$token = '352538299:AAGqOodOgBZmLjN4HUIJrnxr6avK50KE1N4';
//$chatID = -166511690;

$messaggio = ':::::::  <b>Заявка с сайта</b>' . '%0A';
//if ($data['model']) {
//    $messaggio .= 'Заказ: <b>' . $data['model'] . '</b>' . '%0A';
//}
$messaggio .= 'Имя отправителя: <b>' . $data['name'] . '</b>' . '%0A';
$messaggio .= 'Контактный телефон: <b>' . $data['phone'] . '</b>' . '%0A';
$messaggio .= 'E-mail: <b>' . $data['email'] . '</b>' . '%0A';
//$messaggio .= 'Город: <b>' . $data['city'] . '</b>' . '%0A';
$messaggio .= 'Заказ: <b>' . $data['model'] . '</b>' . '%0A';


$url = "https://api.telegram.org/" . $token . "/sendMessage?chat_id=" . $chatID . "&parse_mode=HTML&text=" . $messaggio;
//$url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chatID . "&parse_mode=HTML&text=";
//$url = $url . $messaggio;
$ch = curl_init();
$optArray = array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true
);
curl_setopt_array($ch, $optArray);
$result = curl_exec($ch);
curl_close($ch);
?>