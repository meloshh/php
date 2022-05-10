<?php

namespace Framework;

class RouteDefinition
{
    public array $methods;
    public string $uri;
    public array $handler;

    public function __construct(array $methods, string $uri, array $handler)
    {
        $this->methods = $methods;
        $this->uri = $uri;
        $this->handler = $handler;
    }
}