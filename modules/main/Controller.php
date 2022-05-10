<?php

namespace Modules\Main;

class Controller
{
    public function home()
    {
        header('Content-Type: application/json');
        echo json_encode('homepage');

        die();
    }
}