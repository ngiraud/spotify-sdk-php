<?php

namespace Spotify\Helpers;

use ArrayAccess;

class Arr
{
    public static function accessible(mixed $value): bool
    {
        return is_array($value) || $value instanceof ArrayAccess;
    }

    public static function exists(array|ArrayAccess $array, int|float|string $key): bool
    {
        if ($array instanceof ArrayAccess) {
            return $array->offsetExists($key);
        }

        if (is_float($key)) {
            $key = (string) $key;
        }

        return array_key_exists($key, $array);
    }

    public static function only(array $array, array|string $keys): array
    {
        return array_intersect_key($array, array_flip((array) $keys));
    }

    public static function get(array $array, array|string|null $key, mixed $default = null): mixed
    {
        if (! self::accessible($array)) {
            return $default;
        }

        if (is_null($key)) {
            return $array;
        }

        if (self::exists($array, $key)) {
            return $array[$key];
        }

        if (! str_contains($key, '.')) {
            return $array[$key] ?? $default;
        }

        foreach (explode('.', $key) as $segment) {
            if (self::accessible($array) && self::exists($array, $segment)) {
                $array = $array[$segment];
            } else {
                return $default;
            }
        }

        return $array;
    }
}
