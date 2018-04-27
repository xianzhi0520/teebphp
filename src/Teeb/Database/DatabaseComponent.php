<?php

namespace Teeb\Database;

use Teeb\Base\Component;
use Teeb\Database\Model;
use Teeb\Database\ConnectionFactory;
use Teeb\Database\DatabaseManager;

class DatabaseComponent extends Component
{
    public function boot() 
    {
        Model::setConnectionResolver($this->app['db']);
    }

    public function register()
    {
        $this->app->singleton('db.factory', function ($app) {
            return new ConnectionFactory($app);
        });
        
        $this->app->singleton('db', function ($app) {
            return new DatabaseManager($app, $app['db.factory']);
        });
    }

    public function names()
    {
        return ['db'];
    }
}
