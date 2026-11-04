<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');

require_once __DIR__ . '/includes/admin-auth.php';
require_once __DIR__ . '/includes/image-upload.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    spoon_upload_response(['success' => false, 'error' => 'Метод не поддерживается'], 405);
}

if (!spoon_admin_is_authenticated()) {
    spoon_upload_response(['success' => false, 'error' => 'Требуется авторизация'], 403);
}

$filename = $_POST['filename'] ?? '';
if (!is_string($filename) || $filename === '') {
    spoon_upload_response(['success' => false, 'error' => 'Не указано имя файла'], 400);
}

$delete = spoon_delete_image(__DIR__ . '/tovar', $filename, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
if (!$delete['ok']) {
    spoon_upload_response(['success' => false, 'error' => $delete['error']], $delete['status']);
}

spoon_upload_response(['success' => true, 'message' => 'Файл успешно удален']);
