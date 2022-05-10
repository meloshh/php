<?php

use Framework\Request;

if (! function_exists('request')) {
    function request(): Request
    {
        return $GLOBALS['program']->request;
    }
}

if (! function_exists('dd')) {
    function dd(... $vars)
    {
        header('Content-Type: application/json');
        echo json_encode($vars);

        die();
    }
}
