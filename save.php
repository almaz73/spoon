<?php
// Проверяем, есть ли данные
if (isset($_POST['filename']) && isset($_POST['content'])) {
    $filename = 'datas/' . basename($_POST['filename']); // Базовая защита от выхода из папки
    $content = $_POST['content'];

    // Создаем директорию, если её нет
    if (!file_exists('datas')) {
        mkdir('datas', 0777, true);
    }

    // Записываем файл
    if (file_put_contents($filename, $content) !== false) {
        echo "Файл успешно сохранен: " . $filename;
    } else {
        echo "Ошибка при сохранении файла.";
    }
} else {
    echo "Нет данных для сохранения.";
}
?>
