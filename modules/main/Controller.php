<?php

namespace Modules\Main;

use Framework\Cookie;
use Framework\Encryption;
use Framework\JsonResponse;
use Framework\Response;
use Framework\Storage;
use Framework\TempStorage;
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

    public function fileUpload()
    {
        $storage = new Storage();
        $tempStorage = new TempStorage();
        $storage->writeUploadedFile('public', request()->files['profilePic'], $tempStorage);

        $response = new JsonResponse([]);
        $response->send();
    }

    public function cookie()
    {
        Cookie::createOrUpdate('test_cookie', 'oreo', 3, true);
        // Cookie::delete('test_cookie');

        $response = new JsonResponse([Encryption::decrypt(Cookie::get('test_cookie'))]);
        $response->send();
    }

    public function encryption()
    {
        $raw = 'Holy moly';
        $cipher = Encryption::encrypt($raw);

        $response = new Response(Encryption::decrypt($cipher));
        $response->send();
    }

    public function session()
    {
        $response = new JsonResponse($_SESSION);
        $response->send();
    }
}