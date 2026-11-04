<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');

require_once __DIR__ . '/includes/admin-auth.php';

function spoon_banners_response(array $payload, int $status = 200): void
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    header('X-Content-Type-Options: nosniff');
    header('Cache-Control: no-store');
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'GET') {
    spoon_banners_response(['success' => false, 'error' => 'Метод не поддерживается'], 405);
}

if (!spoon_admin_is_authenticated()) {
    spoon_banners_response(['success' => false, 'error' => 'Требуется авторизация'], 403);
}

$imagesDir = __DIR__ . '/banners';
$result = [];

foreach (scandir($imagesDir) ?: [] as $image) {
    if ($image === '.' || $image === '..') {
        continue;
    }

    $path = $imagesDir . DIRECTORY_SEPARATOR . $image;

    if (is_file($path) && strtolower(pathinfo($image, PATHINFO_EXTENSION)) === 'jpg') {
        $result[] = $image;
    }
}

sort($result, SORT_NATURAL | SORT_FLAG_CASE);

spoon_banners_response($result);
