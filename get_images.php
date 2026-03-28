<?php
// Папка с фотографиями
$imagesDir = 'images/';
// Сканируем папку, исключая . и ..
$images = array_diff(scandir($imagesDir), array('..', '.'));

// Формируем полный путь к файлам
$result = [];
foreach ($images as $image) {
    $result[] = $imagesDir . $image;
}

// Отправляем заголовки для JSON
header('Content-Type: application/json');
// Выводим список фото в формате JSON [1, 9]
echo json_encode($result);
?>