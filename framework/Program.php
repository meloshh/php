<?php

namespace Framework;

use FastRoute;

class Program
{
    public Request $request;

    function __construct(Request $request = null)
    {
        $this->request = $request ?? new Request();
    }

    public function run()
    {
        $this->route();
    }

    protected function route()
    {
        $request = \request();

        $routeFilepaths = [
            'routes/main.php'
        ];

        $dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) use ($routeFilepaths) {
            foreach ($routeFilepaths as $routeFilepath) {
                // dd(P_DIR.$routeFilepath);
                $routeDefinitions = require_once P_DIR.$routeFilepath;

                foreach ($routeDefinitions as $routeDefinition) {
                    $r->addRoute($routeDefinition->methods, $routeDefinition->uri, $routeDefinition->handler);
                }
            }
        });

        $routeInfo = $dispatcher->dispatch($request->method, $request->uri);

        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                dd('Route not found');
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];

                dd('Route method not allowed');
                break;
            case FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                // ... call $handler with $vars

                dd('Route found');

                break;
        }
    }
}




