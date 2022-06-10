<?php

namespace Framework;

class Request
{
    public string $uri;
    public string $method;
    public array $handler;
    public array $data;
    public array $headers;
    public array $files;
    public array $cookies;
    public bool $wantsJson;

    public function __construct(string $uri = null, string $method = null, array $data = null,
        array $headers = null)
    {
        // uri
        if (!$uri) {
            $uri = $_SERVER['REQUEST_URI'];
        }

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $this->uri = rawurldecode($uri);

        // method
        $this->method = $method ?? $_SERVER['REQUEST_METHOD'];

        // data
        if ($data) {
            $this->data = $data;
        } else {
            $this->data = $_GET;
            $this->data = array_merge($this->data, $_POST);
        }

        // headers
        $this->headers = $headers ?? getallheaders();

        // getallheaders() can return false
        if (!$this->headers) {
            $this->headers = [];
        }

        // wantsJson
        if (isset($this->headers['Accept'])) {
            $this->wantsJson = $this->headers['Accept'] === 'application/json';
        }
    }
}