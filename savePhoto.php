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

if (!spoon_admin_require_csrf()) {
    spoon_upload_response(['success' => false, 'error' => 'Неверный CSRF-токен'], 403);
}

$upload = spoon_process_image_upload($_FILES['photo'] ?? [], __DIR__ . '/tovar', ['jpg', 'png', 'gif', 'webp']);
if (!$upload['ok']) {
    spoon_upload_response(['success' => false, 'error' => $upload['error']], $upload['status']);
}

spoon_upload_response(['success' => true, 'filename' => $upload['filename']]);
