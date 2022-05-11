<?php

namespace Framework;

class Request
{
    public string $uri;
    public string $method;
    public array $handler;
    public array $data;
    public array $files;
    public array $headers;
    public bool $wantsJson;

    public function __construct(string $uri = null, string $method = null, array $data = null,
        array $headers = null, bool $wantsJson = null)
    {
        if (!$uri) {
            $uri = $_SERVER['REQUEST_URI'];
        }

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }

        $this->uri = rawurldecode($uri);

        $this->method = $method ?? $_SERVER['REQUEST_METHOD'];

        if ($data) {
            $this->data = $data;
        } else {
            $this->data = $_GET;
            $this->data = array_merge($this->data, $_POST);
        }

        $this->headers = $headers ?? getallheaders();

        if ($wantsJson) {
            $this->wantsJson = $wantsJson;
        } else {
            if (isset($this->headers['Accept']) && $this->headers['Accept']) {
                $this->wantsJson = $this->headers['Accept'] === 'application/json';
            } else {
                $this->wantsJson = false;
            }
        }
    }
}