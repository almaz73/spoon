<?php
function spoon_scheme(): string
{
    return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
}

function spoon_host(): string
{
    return $_SERVER['HTTP_HOST'] ?? 'xn----htbeijemffg.xn--p1ai';
}

function spoon_base_path(): string
{
    $dir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/'));
    return rtrim($dir, '/') . '/';
}

function spoon_site_url(): string
{
    return spoon_scheme() . '://' . spoon_host() . spoon_base_path();
}

function spoon_current_url(): string
{
    return spoon_scheme() . '://' . spoon_host() . strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
}

function spoon_h(?string $value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function spoon_json_ld(array $data): string
{
    return (string)json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP);
}

function spoon_breadcrumbs(array $items): void
{
    if ($items === []) {
        return;
    }

    $lastIndex = count($items) - 1;
    $list = [];

    echo '<nav class="breadcrumbs" aria-label="Хлебные крошки">';
    foreach ($items as $index => $item) {
        $name = (string)($item['name'] ?? '');
        $href = (string)($item['href'] ?? '');
        $url = (string)($item['url'] ?? '');

        if ($url === '' && $href !== '') {
            $url = $href === 'index.php' ? spoon_site_url() : spoon_site_url() . ltrim($href, '/');
        }

        if ($index > 0) {
            echo '<span>/</span>';
        }
        if ($href !== '' && $index < $lastIndex) {
            echo '<a href="' . spoon_h($href) . '">' . spoon_h($name) . '</a>';
        } else {
            echo '<span>' . spoon_h($name) . '</span>';
        }

        if ($name !== '') {
            $listItem = ['@type' => 'ListItem', 'position' => $index + 1, 'name' => $name];
            if ($url !== '') {
                $listItem['item'] = $url;
            }
            $list[] = $listItem;
        }
    }
    echo '</nav>';

    echo '<script type="application/ld+json">' . spoon_json_ld([
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $list,
    ]) . '</script>';
}

function spoon_organization_schema(): array
{
    $siteUrl = spoon_site_url();

    return [
        '@type' => 'Organization',
        '@id' => $siteUrl . '#organization',
        'name' => 'Ложкин Дом',
        'url' => $siteUrl,
        'logo' => [
            '@type' => 'ImageObject',
            'url' => $siteUrl . 'images/logo.png',
            'width' => 300,
            'height' => 72,
        ],
        'description' => 'Оптово-производственная компания «Ложкин Дом»: сувениры и столовые приборы с гравировкой, доставка по России и странам СНГ.',
        'email' => 'lojkin.dom@mail.ru',
        'telephone' => '+7-952-042-56-27',
        'contactPoint' => [
            '@type' => 'ContactPoint',
            'telephone' => '+7-952-042-56-27',
            'email' => 'lojkin.dom@mail.ru',
            'contactType' => 'customer service',
            'availableLanguage' => 'ru',
            'areaServed' => ['RU', 'BY', 'KZ', 'KG', 'UZ', 'TJ', 'AM', 'AZ'],
        ],
    ];
}
