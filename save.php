<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Проверяем, есть ли данные
if (isset($_POST['filename']) && isset($_POST['content'])) {
    $filename = 'datas/' . basename($_POST['filename']); // Базовая защита от выхода из папки
    $content = $_POST['content'];
    
    // Создаем директорию, если её нет
    if (!file_exists('datas')) {
        mkdir('datas', 0777, true);
    }
    
    // Если файл существует, создаем резервную копию
    if (file_exists($filename)) {
        // Определяем имя резервного файла
        $backupFilename = dirname($filename) . '/' . pathinfo($filename, PATHINFO_FILENAME) . '_copy.' . pathinfo($filename, PATHINFO_EXTENSION);
        
        // Если резервный файл уже существует, удаляем его
        if (file_exists($backupFilename)) {
            unlink($backupFilename);
        }
        
        // Создаем копию файла
        if (!copy($filename, $backupFilename)) {
            echo json_encode(['success' => false, 'error' => 'Не удалось создать резервную копию файла']);
            exit;
        }
    }
    
    // Записываем файл
    if (file_put_contents($filename, $content) !== false) {
        echo json_encode(['success' => true, 'message' => 'Файл успешно сохранен: ' . $filename]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Ошибка при сохранении файла.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Нет данных для сохранения.']);
}
?>
