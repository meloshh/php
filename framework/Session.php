<?php

namespace Framework;

abstract class Session
{
    public static function startIfNotStarted()
    {
        if (php_sapi_name() === 'cli') {
            return;
        }

        // already started
        if (static::isStarted()) {
            return;
        }

        // no request
        if (!request()) {
            return;
        }

        session_start([
            'save_path' => P_DIR.'/storage/sessions',
            'gc_maxlifetime' => program()->configuration->sessionExpirationMinutes * 60,
            'cookie_lifetime' => program()->configuration->sessionExpirationMinutes * 60,
            'name' => 'session',
            'use_strict_mode' => true,
        ]);
    }

    public static function add(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key): mixed
    {
        return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : null;
    }

    protected static function getStatus()
    {
        return session_status();
    }

    protected static function isStarted()
    {
        return static::getStatus() === PHP_SESSION_ACTIVE;
    }
}