<?php

namespace Framework;

abstract class Encryption
{
    public static function encrypt(string $value)
    {
        $key = static::getKey();
        $nonce = random_bytes( SODIUM_CRYPTO_SECRETBOX_NONCEBYTES );

        $encrypted = sodium_crypto_secretbox($value, $nonce, $key);

        return base64_encode($nonce.$encrypted);
    }

    public static function decrypt(string $cipher): false|string
    {
        $key = static::getKey();

        $decoded = base64_decode($cipher);
        $nonce = mb_substr($decoded, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, '8bit');

        $encrypted_result = mb_substr($decoded, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, null, '8bit');

        return sodium_crypto_secretbox_open($encrypted_result, $nonce, $key);
    }

    protected static function getKey(): string
    {
        return hex2bin(config()->encryptionKey);
    }
}