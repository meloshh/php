<?php

namespace Framework;

class JsonResponse extends Response
{
    public function __construct(array $data, int $status = 200)
    {
        if (php_sapi_name() === 'cli') {
            $strData = json_encode($data, JSON_PRETTY_PRINT);
        } else {
            $strData = json_encode($data);
        }

        parent::__construct($strData, $status);
    }

    public function send()
    {
        $this->addHeaders(['Content-Type' => 'application/json']);

        parent::send();
    }
}