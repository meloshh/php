<?php

namespace Framework;

abstract class ErrorHandler
{
    public static function setup()
    {
        set_error_handler('\Framework\ErrorHandler::error');
        set_exception_handler('\Framework\ErrorHandler::uncaughtException');
    }

    public static function uncaughtException(\Throwable $exception): void
    {
        if (program()->logger) {
            program()->logger->error($exception);
        }

        $response = new JsonResponse([
            'message' => $exception->getMessage(),
            'file' > $exception->getFile(),
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
}