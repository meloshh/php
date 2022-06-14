<?php

namespace Framework;

abstract class Hash
{
    public static function make(string $str): string
    {
        return password_hash($str, PASSWORD_DEFAULT);
    }

    public static function verify(string $raw, string $hashed): bool
    {
        return password_verify($raw, $hashed);
    }
}