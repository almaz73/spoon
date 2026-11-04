<?php
const SPOON_ADMIN_USER = 'носов';
const SPOON_ADMIN_PASSWORD = 'носов';
const SPOON_ADMIN_SALT = 'f07854328kazan27032026fag584ghf63h264yh245h5y';

function spoon_admin_cookie_value(): string
{
    return md5(SPOON_ADMIN_PASSWORD . SPOON_ADMIN_SALT);
}

function spoon_admin_is_authenticated(): bool
{
    $cookie = $_COOKIE['PrivatePageLogin'] ?? '';
    return is_string($cookie) && $cookie !== '' && hash_equals(spoon_admin_cookie_value(), $cookie);
}
