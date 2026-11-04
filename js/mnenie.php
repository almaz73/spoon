<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');

require_once dirname(__DIR__) . '/includes/image-upload.php';
require_once dirname(__DIR__) . '/includes/request-guard.php';

function mnenie_redirect(string $anchor): void
{
    header('Location: /#' . $anchor, true, 303);
    exit;
}

function mnenie_field(string $key, int $maxLength): string
{
    $value = $_POST[$key] ?? '';
    if (!is_string($value)) {
        return '';
    }
    $value = trim($value);
    if (function_exists('mb_substr')) {
        return mb_substr($value, 0, $maxLength, 'UTF-8');
    }
    return substr($value, 0, $maxLength);
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    mnenie_redirect('badsend');
}

if (($_POST['antibot'] ?? '') !== '40') {
    mnenie_redirect('badsend');
}

if (empty($_POST['mail_msg']) || !is_string($_POST['mail_msg'])) {
    mnenie_redirect('badsend');
}

if (!spoon_request_is_same_origin() || !spoon_rate_limit_allow('mnenie:' . spoon_request_ip(), 5, 1800)) {
    mnenie_redirect('badsend');
}

$name = mnenie_field('mail_name', 100);
$phone = mnenie_field('mail_phone', 50);
$city = mnenie_field('mail_city', 100);
$mnenie = mnenie_field('mail_msg', 5000);

$attachmentPath = null;
$fileError = $_FILES['mail_file']['error'] ?? UPLOAD_ERR_NO_FILE;
if ($fileError !== UPLOAD_ERR_NO_FILE) {
    $upload = spoon_process_image_upload(
        $_FILES['mail_file'],
        dirname(__DIR__) . '/uploads/mnenie',
        ['jpg', 'png', 'gif', 'webp'],
        null,
        true
    );
    if (!$upload['ok']) {
        mnenie_redirect('badsend');
    }

    $attachmentPath = realpath(dirname(__DIR__) . '/uploads/mnenie/' . $upload['filename']);
    if ($attachmentPath === false) {
        mnenie_redirect('badsend');
    }

    register_shutdown_function(static function () use ($attachmentPath): void {
        if (is_file($attachmentPath)) {
            @unlink($attachmentPath);
        }
    });
}

$thm = 'Новый отзыв на сайте';

$msg = 'Name: <b>' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '</b> <br>';
$msg .= 'Phone: <b>' . htmlspecialchars($phone, ENT_QUOTES, 'UTF-8') . '</b> <br>';
$msg .= 'City: <b>' . htmlspecialchars($city, ENT_QUOTES, 'UTF-8') . '</b> <br>';
$msg .= 'Mnenie: <b>' . htmlspecialchars($mnenie, ENT_QUOTES, 'UTF-8') . '</b> <br>';

$mail_to = 'lojkin.dom@mail.ru, lih1989@yandex.ru, almaz73@gmail.com';

$headers = "From: Сайт Ложкин Дом <mail@xn----htbeijemffg.xn--p1ai>\n";
$headers .= "Content-Type: text/html; charset=utf-8\n";

$sent = $attachmentPath === null
    ? mail($mail_to, $thm, $msg, $headers)
    : send_mail($mail_to, $thm, $msg, $attachmentPath);

mnenie_redirect($sent ? 'goodsend' : 'badsend');

function send_mail(string $to, string $subject, string $html, string $path): bool
{
    $file = @file_get_contents($path);
    if ($file === false) {
        return false;
    }

    $boundary = '--' . md5(uniqid('', true));
    $filename = basename($path);

    $headers = "From: Сайт Ложкин Дом <mail@xn----htbeijemffg.xn--p1ai>\n";
    $headers .= "MIME-Version: 1.0\n";
    $headers .= "Content-Type: multipart/mixed; boundary={$boundary}\n";

    $multipart = "--{$boundary}\n";
    $multipart .= "Content-Type: text/html; charset=utf-8\n";
    $multipart .= "Content-Transfer-Encoding: 8bit\n\n";
    $multipart .= $html . "\n\n";

    $multipart .= "--{$boundary}\n";
    $multipart .= "Content-Type: application/octet-stream; name=\"{$filename}\"\n";
    $multipart .= "Content-Transfer-Encoding: base64\n";
    $multipart .= "Content-Disposition: attachment; filename=\"{$filename}\"\n\n";
    $multipart .= chunk_split(base64_encode($file)) . "\n";
    $multipart .= "--{$boundary}--\n";

    return mail($to, $subject, $multipart, $headers);
}
