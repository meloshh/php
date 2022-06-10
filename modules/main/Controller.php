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

    public function token()
    {
        $response = new JsonResponse([
            'token' => randomStr(),
        ]);
        $response->send();
    }

    public function exception()
    {
        throw new \Exception('Me exception');
        (new JsonResponse([]))->send();
    }
}