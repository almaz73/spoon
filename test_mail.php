<?php
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

mail('almaz73@yandex.ru', 'Проверка', 'Текст для проверки');
