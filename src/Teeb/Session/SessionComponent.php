<?php

namespace Teeb\Session;

use Teeb\Base\Component;

class SessionComponent extends Component
{

    protected $lazy = true;

    public function register()
    {
        $this->registerManager();
    }

    protected function registerManager()
    {
        $this->app->singleton('session', function ($app) {
            return new SessionManager($app);
        });
    }

    public function names()
    {
        return ['session'];
    }

}
