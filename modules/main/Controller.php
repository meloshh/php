<?php

namespace Modules\Main;

use Framework\JsonResponse;

class Controller
{
    public function home()
    {
        $response = new JsonResponse(['homepage']);
        $response->send();
    }
}