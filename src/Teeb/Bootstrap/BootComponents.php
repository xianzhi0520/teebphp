<?php

namespace Teeb\Bootstrap;

use Teeb\Base\Application;

class BootComponents
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function bootstrap()
    {
        $this->app->boot();
    }
}
