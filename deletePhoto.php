<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if filename was provided
if (!isset($_POST['filename'])) {
    echo json_encode(['success' => false, 'error' => 'Не указано имя файла']);
    exit;
}

// Sanitize filename to prevent path traversal attacks
$filename = basename($_POST['filename']);
$filepath = 'tovar/' . $filename;

// Check if file exists
if (!file_exists($filepath)) {
    echo json_encode(['success' => false, 'error' => 'Файл не существует']);
    exit;
}

// Attempt to delete the file
if (unlink($filepath)) {
    echo json_encode(['success' => true, 'message' => 'Файл успешно удален']);
} else {
    echo json_encode(['success' => false, 'error' => 'Не удалось удалить файл']);
}
?>
