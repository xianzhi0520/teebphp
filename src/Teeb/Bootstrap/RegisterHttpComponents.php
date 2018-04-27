<?php

namespace Teeb\Bootstrap;

use Teeb\Base\Application;
use Teeb\Support\ComponentRepository;
use Teeb\Http\Request;
use Teeb\Http\Response;
use Teeb\Http\Route;
use Teeb\View\View;

class RegisterHttpComponents
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function bootstrap()
    {
        $this->app->singleton('request', function($app) {
            return new Request($app);
        });

        $this->app->singleton('response', function($app) {
            return new Response($app);
        });

        $this->app->singleton('route', function($app) {
            return new Route($app, $app['request']);
        });

        (new ComponentRepository($this->app))->load();
    }
}
