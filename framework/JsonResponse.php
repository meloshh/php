<?php

namespace Framework;

class JsonResponse extends Response
{
    public function __construct(array $data, int $status = 200)
    {
        parent::__construct($data, $status);
    }

    public function send()
    {
        $this->addHeaders(['Content-Type' => 'application/json']);

        http_response_code($this->status);

        echo json_encode($this->data);
        die();
    }
}