<?php

namespace Teeb\Redis;

use Teeb\Base\Component;

class RedisComponent extends Component
{

    protected $lazy = true;

    public function register()
    {
        $this->app->singleton('redis', function ($app) {
            return new RedisManager($app);
        });
    }

    public function names()
    {
        return ['redis'];
    }
    
}
