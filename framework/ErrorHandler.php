<?php

namespace Framework;

abstract class ErrorHandler
{
    public static function setup()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        ini_set('log_errors', 1);
        ini_set('error_log', 'tmp/php-errors.log');

        set_error_handler('\Framework\ErrorHandler::error');
        set_exception_handler('\Framework\ErrorHandler::uncaughtException');
        // register_shutdown_function('\Framework\ErrorHandler::shutdownFunction');
    }

    public static function uncaughtException(\Throwable $exception): void
    {
        if (program()->logger) {
            program()->logger->error($exception);
        }

        $response = new JsonResponse([
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'code' => $exception->getCode(),
            'trace' => $exception->getTrace(),
        ], 500);
        $response->send();
    }

    public static function error($no, $str, $file, $line): void
    {
        if (program()->logger) {
            program()->logger->error($str, ['file' => $file, 'line' => $line, 'no' => $no]);
        }

        $response = new JsonResponse([$no, $str, $file, $line], 500);
        $response->send();
    }

    public static function shutdownFunction()
    {
        $e = error_get_last();

        if ($e) {
            if (program()->logger) {
                program()->logger->error(implode(', ', $e));
            }

            $response = new JsonResponse($e, 500);
            $response->send();
        }
    }
}