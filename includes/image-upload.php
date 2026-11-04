<?php

const SPOON_UPLOAD_MAX_BYTES = 8 * 1024 * 1024;

function spoon_upload_response(array $payload, int $status = 200): void
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    header('X-Content-Type-Options: nosniff');
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    exit;
}

function spoon_image_extension(int $type): ?string
{
    return match ($type) {
        IMAGETYPE_JPEG => 'jpg',
        IMAGETYPE_PNG => 'png',
        IMAGETYPE_GIF => 'gif',
        IMAGETYPE_WEBP => 'webp',
        default => null,
    };
}

function spoon_process_image_upload(array $file, string $directory, array $allowedExtensions, ?array $allowedBasenames = null, bool $randomName = false): array
{
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        return ['ok' => false, 'status' => 400, 'error' => 'Файл не загружен или произошла ошибка загрузки'];
    }

    $tmp = $file['tmp_name'] ?? '';
    if (!is_string($tmp) || $tmp === '' || !is_uploaded_file($tmp)) {
        return ['ok' => false, 'status' => 400, 'error' => 'Некорректный загруженный файл'];
    }

    $size = @filesize($tmp);
    if ($size === false || $size === 0) {
        return ['ok' => false, 'status' => 400, 'error' => 'Пустой файл'];
    }
    if ($size > SPOON_UPLOAD_MAX_BYTES) {
        return ['ok' => false, 'status' => 413, 'error' => 'Файл слишком большой (максимум 8 МБ)'];
    }

    $info = @getimagesize($tmp);
    $extension = is_array($info) ? spoon_image_extension((int)$info[2]) : null;
    if ($extension === null || !in_array($extension, $allowedExtensions, true)) {
        return ['ok' => false, 'status' => 400, 'error' => 'Файл не является изображением допустимого формата'];
    }

    $originalName = basename((string)($file['name'] ?? ''));
    $basename = pathinfo($originalName, PATHINFO_FILENAME);
    $basename = preg_replace('/[^A-Za-z0-9_-]+/', '-', (string)$basename);
    $basename = trim((string)$basename, '-_');
    if ($randomName) {
        $basename = 'file-' . bin2hex(random_bytes(8));
    } elseif ($basename === '') {
        $basename = 'photo-' . bin2hex(random_bytes(4));
    }
    if (!$randomName && $allowedBasenames !== null && !in_array($basename, $allowedBasenames, true)) {
        return ['ok' => false, 'status' => 400, 'error' => 'Недопустимое имя файла'];
    }

    $filename = $basename . '.' . $extension;
    $target = rtrim($directory, '/\\') . DIRECTORY_SEPARATOR . $filename;

    if (!is_dir($directory) || !is_writable($directory)) {
        error_log('upload: каталог недоступен для записи: ' . $directory);
        return ['ok' => false, 'status' => 500, 'error' => 'Каталог для загрузки недоступен'];
    }

    if (!move_uploaded_file($tmp, $target)) {
        error_log('upload: не удалось переместить файл в ' . $target);
        return ['ok' => false, 'status' => 500, 'error' => 'Ошибка при сохранении файла'];
    }

    return ['ok' => true, 'status' => 200, 'filename' => $filename];
}

function spoon_delete_image(string $directory, string $filename, array $allowedExtensions): array
{
    $filename = basename(str_replace('\\', '/', $filename));
    if (!preg_match('/^[A-Za-z0-9_-]+\.([A-Za-z0-9]+)$/', $filename, $matches)) {
        return ['ok' => false, 'status' => 400, 'error' => 'Недопустимое имя файла'];
    }

    $extension = strtolower($matches[1]);
    if (!in_array($extension, $allowedExtensions, true)) {
        return ['ok' => false, 'status' => 400, 'error' => 'Недопустимый тип файла'];
    }

    $realDirectory = realpath($directory);
    if ($realDirectory === false) {
        error_log('delete: каталог не найден: ' . $directory);
        return ['ok' => false, 'status' => 500, 'error' => 'Каталог не найден'];
    }

    $target = realpath($realDirectory . DIRECTORY_SEPARATOR . $filename);
    if ($target === false || !is_file($target)) {
        return ['ok' => false, 'status' => 404, 'error' => 'Файл не существует'];
    }
    if (dirname($target) !== $realDirectory) {
        return ['ok' => false, 'status' => 400, 'error' => 'Недопустимый путь к файлу'];
    }

    if (!unlink($target)) {
        error_log('delete: не удалось удалить ' . $target);
        return ['ok' => false, 'status' => 500, 'error' => 'Не удалось удалить файл'];
    }

    return ['ok' => true, 'status' => 200, 'filename' => $filename];
}
