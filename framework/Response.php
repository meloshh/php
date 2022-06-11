<?php

namespace Framework;

class Response
{
    public string $data;
    public int $status;
    public array $headers = [];

    public function __construct(string $data, int $status = 200)
    {
        $this->data = $data;
        $this->status = $status;
    }

    public function send()
    {
        http_response_code($this->status);

        echo($this->data);
        die();
    }

    public function addHeaders(array $headers)
    {
        $this->headers = array_merge($this->headers, $headers);

        foreach ($headers as $key => $value) {
            header($key.': '.$value);
        }
    }
}