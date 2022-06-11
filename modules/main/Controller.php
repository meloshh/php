<?php

namespace Modules\Main;

use Framework\JsonResponse;
use Framework\Response;
use Framework\View;

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

    public function view()
    {
        $view = new View('../modules/main/html', 'hello', [
            'name' => 'World',
        ]);

        $response = new Response($view->getRenderStr());
        $response->send();
    }
}