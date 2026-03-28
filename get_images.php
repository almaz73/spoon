<?php
// Папка с фотографиями
$imagesDir = 'tovar/';
// Сканируем папку, исключая . и ..
$images = array_diff(scandir($imagesDir), array('..', '.'));


$result = [];
foreach ($images as $image) {
//    $result[] = $imagesDir . $image; // Формируем полный путь к файлам
    $result[] = $image;
}

// Отправляем заголовки для JSON
header('Content-Type: application/json');
// Выводим список фото в формате JSON [1, 9]
echo json_encode($result);
?>