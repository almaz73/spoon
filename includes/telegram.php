<?php

function spoon_telegram_config(): ?array
{
    $token = getenv('SPOON_TELEGRAM_BOT_TOKEN');
    $chatId = getenv('SPOON_TELEGRAM_CHAT_ID');

    if ((!is_string($token) || $token === '') || (!is_string($chatId) || $chatId === '')) {
        $token = '';
        $chatId = '';

        if (is_file(__DIR__ . '/telegram-config.php')) {
            $config = require __DIR__ . '/telegram-config.php';
            if (is_array($config)) {
                $token = is_string($config['token'] ?? null) ? $config['token'] : '';
                $chatId = is_string($config['chat_id'] ?? null) ? $config['chat_id'] : '';
            }
        }
    }

    $token = trim((string)$token);
    $chatId = trim((string)$chatId);

    if ($token === '' || $chatId === '') {
        return null;
    }

    return ['token' => $token, 'chat_id' => $chatId];
}

function spoon_telegram_send(string $message): bool
{
    $config = spoon_telegram_config();
    if ($config === null) {
        error_log('telegram: не заданы SPOON_TELEGRAM_BOT_TOKEN и SPOON_TELEGRAM_CHAT_ID');
        return false;
    }

    if (!function_exists('curl_init')) {
        error_log('telegram: расширение curl не доступно');
        return false;
    }

    $ch = curl_init('https://api.telegram.org/bot' . $config['token'] . '/sendMessage');
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query([
            'chat_id' => $config['chat_id'],
            'parse_mode' => 'HTML',
            'text' => $message,
        ]),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_TIMEOUT => 10,
    ]);

    $result = curl_exec($ch);
    $status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $ok = $result !== false && $status >= 200 && $status < 300;
    if (!$ok) {
        error_log('telegram: отправка не удалась, HTTP ' . $status);
    }

    return $ok;
}
