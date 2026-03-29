<?php
// Папка с фотографиями
$imagesDir = 'banners/';
// Сканируем папку, исключая . и ..
$images = array_diff(scandir($imagesDir), array('..', '.'));


$result = [];
foreach ($images as $image) {
    $result[] = $image;
}

// Отправляем заголовки для JSON
header('Content-Type: application/json');
// Выводим список фото в формате JSON [1, 9]
echo json_encode($result);
?>