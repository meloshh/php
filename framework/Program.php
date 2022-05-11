<?php

namespace Framework;

use FastRoute;
use Symfony\Component\ErrorHandler\BufferingLogger;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\ErrorHandler\ErrorHandler;

class Program
{
    public Request $request;
    public Configuration $configuration;

    function __construct(Request $request = null)
    {
        $this->request = $request ?? new Request();
    }

    public function run()
    {
        $this->setupErrorHandling();
        $this->loadConfiguration();
        $this->route();
    }

    protected function route()
    {
        $request = \request();

        $dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
            foreach ($this->configuration->routeFilepaths as $routeFilepath) {
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

                // dd($handler, $vars);
                $request->handler = $handler;
                $handlerInstance = new $handler[0];
                call_user_func_array([$handlerInstance, $handler[1]], $vars);

                break;
        }
    }

    public function setupErrorHandling()
    {
        ErrorHandler::register(new ErrorHandler(new BufferingLogger(), true));
    }

    public function loadConfiguration()
    {
        $this->configuration = require_once P_DIR.'/config/main.php';
    }
}




