<?php

namespace Framework;

class JsonResponse extends Response
{
    public function send()
    {
        $this->addHeaders(['Content-Type' => 'application/json']);

        echo json_encode($this->data);
        die();
    }
}