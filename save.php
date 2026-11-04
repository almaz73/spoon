<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');

require_once __DIR__ . '/includes/admin-auth.php';

function spoon_save_response(array $payload, int $status = 200): void
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    header('X-Content-Type-Options: nosniff');
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    spoon_save_response(['success' => false, 'error' => 'Метод не поддерживается'], 405);
}

if (!spoon_admin_is_authenticated()) {
    spoon_save_response(['success' => false, 'error' => 'Требуется авторизация'], 403);
}

$filename = (string)($_POST['filename'] ?? '');
$content = (string)($_POST['content'] ?? '');

if ($filename !== 'listTovar.js') {
    spoon_save_response(['success' => false, 'error' => 'Недопустимое имя файла'], 400);
}

if ($content === '' || strlen($content) > 2 * 1024 * 1024) {
    spoon_save_response(['success' => false, 'error' => 'Недопустимый размер файла'], 400);
}

if (strpos($content, "\0") !== false || preg_match('/<\?(?:php|=)?/i', $content)) {
    spoon_save_response(['success' => false, 'error' => 'Недопустимое содержимое файла'], 400);
}

if (strpos($content, 'var goods = {};') !== 0
    || !preg_match('/goods\.models\s*=\s*(\[.*\])\s*;?\s*$/s', $content, $matches)) {
    spoon_save_response(['success' => false, 'error' => 'Неверный формат файла товаров'], 400);
}

$models = json_decode($matches[1], true);
$isList = is_array($models)
    && ($models === [] || array_keys($models) === range(0, count($models) - 1));
if (!$isList) {
    spoon_save_response(['success' => false, 'error' => 'Неверный формат списка товаров'], 400);
}

foreach ($models as $model) {
    if (!is_array($model) || $model === []) {
        spoon_save_response(['success' => false, 'error' => 'Неверная структура товара'], 400);
    }
}

$target = __DIR__ . '/datas/listTovar.js';
$backup = __DIR__ . '/datas/listTovar_copy.js';

if (is_file($target) && !copy($target, $backup)) {
    error_log('save.php: не удалось создать резервную копию ' . $backup);
    spoon_save_response(['success' => false, 'error' => 'Не удалось создать резервную копию файла'], 500);
}

if (file_put_contents($target, $content, LOCK_EX) === false) {
    error_log('save.php: не удалось записать ' . $target);
    spoon_save_response(['success' => false, 'error' => 'Ошибка при сохранении файла'], 500);
}

spoon_save_response(['success' => true, 'message' => 'Файл успешно сохранен: listTovar.js']);
