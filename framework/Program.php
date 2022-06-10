<?php

namespace Framework;

use Dotenv\Dotenv;
use FastRoute;
use Framework\CliCommands\ICliCommand;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;

class Program
{
    public Request|null $request;
    public Configuration $configuration;
    public Logger $logger;

    function __construct(Request $request = null)
    {
        $GLOBALS['program'] = $this;
        $this->request = $request;

        if (php_sapi_name() !== 'cli' && ! $request) {
            $this->request = new Request();
        }
    }

    public function run(): void
    {
        $this->setupErrorHandling();
        $this->setupErrorLogging();
        $this->loadConfiguration();
        $this->setupSession();

        // dd($this->configuration);

        if (php_sapi_name() === 'cli') {
            $this->runCliCommand();
        } else {
            $this->route();
        }
    }

    protected function route(): void
    {
        $request = \request();

        if (!$request) {
            throw new \Exception('Trying to route without request');
        }

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

    protected function setupErrorHandling(): void
    {
        // ErrorHandler::register(new ErrorHandler(new BufferingLogger(), true));

        \Framework\ErrorHandler::setup();
    }

    protected function loadConfiguration(): void
    {
        $this->loadEnv();
        $this->configuration = require_once P_DIR.'/config/main.php';
    }

    protected function loadEnv()
    {
        // path without filename
        $dotenv = Dotenv::createImmutable(P_DIR);
        $dotenv->load();
    }

    protected function setupSession()
    {
        Session::startIfNotStarted();
    }

    protected function runCliCommand()
    {
        global $argv;

        $command = $argv[1];

        // dd($this->configuration->getCliCommands());

        $commandClass = $this->configuration->getCliCommands()[$command];

        $commandObj = new $commandClass();

        if (! $commandObj instanceof ICliCommand) {
            throw new \Exception($commandClass.' does not implement ICliCommand');
        }

        $commandObj->run();
    }

    protected function setupErrorLogging(): void
    {
        $this->logger= new Logger('main');
        $this->logger->pushHandler(new StreamHandler(P_DIR.'storage/logs/main.log', Level::Warning));
    }
}




