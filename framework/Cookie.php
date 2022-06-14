<?php

namespace Framework;

abstract class Cookie
{
    public static function createOrUpdate(string $name, string $value, int $expirationMins = 0, bool $encrypt = false)
    {
        $expiration = time() + ($expirationMins * 60);

        $val = $encrypt ? Encryption::encrypt($value) : $value;

        setcookie($name, $val, $expiration);
    }

    public static function get($name): string
    {
        // var_dump($_COOKIE); die();
        return $_COOKIE[$name];
    }

    public static function delete(string $name)
    {
        setcookie($name, '', 1);
    }
}