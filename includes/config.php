<?php

function hq_config(string $name): array
{
    static $cache = [];

    if (!isset($cache[$name])) {
        $path = __DIR__ . '/../config/' . $name . '.php';
        $cache[$name] = file_exists($path) ? require $path : [];
    }

    return $cache[$name];
}

function hq_config_get(string $name, string $key, mixed $default = null): mixed
{
    $config = hq_config($name);
    return $config[$key] ?? $default;
}
