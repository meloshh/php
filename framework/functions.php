<?php

use Framework\Request;
use Framework\Program;

if (! function_exists('program')) {
    function program(): Program
    {
        return $GLOBALS['program'];
    }
}

if (! function_exists('request')) {
    function request(): Request|null
    {
        return \program()->request;
    }
}

if (! function_exists('dd')) {
    function dd(... $vars)
    {
        $response = new \Framework\JsonResponse($vars, 500);
        $response->send();
    }
}

if (! function_exists('randomStr')) {
    function randomStr(int $length = 32)
    {
        $token = bin2hex(random_bytes($length/2));

        return $token;
    }
}
