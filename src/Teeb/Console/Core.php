<?php

namespace Teeb\Console;

use Exception;
use ReflectionMethod;
use Teeb\Base\Application;
use Teeb\Console\Route;
use Teeb\Exception\ConsoleException;

class Core
{

    protected $app;

    protected $bootstrappers = [
        'Teeb\Bootstrap\LoadConfiguration',
        'Teeb\Bootstrap\ConfigureLog',
        'Teeb\Bootstrap\HandleException',
        'Teeb\Bootstrap\RegisterConsoleComponents',
        'Teeb\Bootstrap\BootComponents',
    ];

    protected $internalActions = [
        'Make\\Middleware',
        'Make\\Http',
        'Make\\Console',
        'Make\\Model',
    ];

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function bootstrap()
    {
        if (!$this->app->isBootstrapped()) {
            $this->app->bootstrapWith($this->bootstrappers());
        }
    }

    public function bootstrappers()
    {
        return $this->bootstrappers;
    }

    public function run()
    {
        $this->bootstrap();

        return $this->handle();
    }

    public function handle()
    {
        list($pathInfo, $params) = $this->app->route->resolve();

        echo $this->handleRequest($pathInfo, $params);
    }

    public function handleRequest($route, $params = [])
    {
        if (count(explode('/', $route)) > 2) {
            throw new ConsoleException("The pathinfo only support two level.");
        }

        $pat = '/^[a-zA-Z][a-zA-Z0-9_]*(\/[a-zA-Z][a-zA-Z0-9_]*)?$/';
        if (!preg_match($pat, $route)) {
            throw new ConsoleException("The url format is illegal.");
        }

        $info = $this->createController($route);

        list($controller, $actionId) = $info;
        
        $result = $controller->run($actionId, $params);

        return $result;
    }

    public function createController($route)
    {
        if (strpos($route, '/') !== false) {
            list ($id, $route) = explode('/', $route, 2);
        } else {
            $id = $route;
            $route = '';
        }

        if (strtolower($id) === 'make') {
            $class = 'Teeb\\Console\\MakeController';
        } else {
            $class = 'App\\Console\\' . ucfirst($id . 'Controller');
        }
        
        if (!class_exists($class)) {
            throw new Exception("{$class} doesn't exists.");
        }
        
        if (is_subclass_of($class, 'Teeb\\Console\\Controller')) {
            $instance = $this->app->make($class, [$this->app, $id]);
            return [$instance, $route];
        }

        throw new ConsoleException(
            "Controller must extend from Teeb\Http\Controller.");
    }

}
