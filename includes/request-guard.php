<?php

function spoon_request_ip(): string
{
    return (string)($_SERVER['REMOTE_ADDR'] ?? 'unknown');
}

function spoon_request_is_same_origin(): bool
{
    $host = strtolower((string)($_SERVER['HTTP_HOST'] ?? ''));
    if ($host === '') {
        return false;
    }

    $host = preg_replace('/:\d+$/', '', $host);

    foreach (['HTTP_ORIGIN', 'HTTP_REFERER'] as $key) {
        $value = (string)($_SERVER[$key] ?? '');
        if ($value === '') {
            continue;
        }

        $parts = parse_url($value);
        if (!is_array($parts) || empty($parts['host'])) {
            return false;
        }

        return strtolower((string)$parts['host']) === $host;
    }

    return true;
}

function spoon_rate_limit_file(string $bucket): string
{
    $dir = rtrim(sys_get_temp_dir(), '/\\') . DIRECTORY_SEPARATOR . 'spoon-rate-limit';
    if (!is_dir($dir)) {
        @mkdir($dir, 0700, true);
    }

    return $dir . DIRECTORY_SEPARATOR . hash('sha256', $bucket) . '.json';
}

function spoon_rate_limit_allow(string $bucket, int $max, int $window): bool
{
    if ($max < 1 || $window < 1) {
        return true;
    }

    $file = spoon_rate_limit_file($bucket);
    $now = time();
    $data = json_decode((string)@file_get_contents($file), true);
    $hits = is_array($data) && isset($data['hits']) && is_array($data['hits']) ? $data['hits'] : [];

    $hits = array_values(array_filter(
        $hits,
        static fn($timestamp): bool => is_int($timestamp) && $now - $timestamp < $window
    ));

    if (count($hits) >= $max) {
        return false;
    }

    $hits[] = $now;

    if (@file_put_contents($file, json_encode(['hits' => $hits]), LOCK_EX) === false) {
        error_log('rate-limit: не удалось записать файл ' . $file);
    }

    return true;
}
