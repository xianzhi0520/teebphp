<?php

namespace App\Middleware;

use Teeb\Base\Middleware;

class {{middleware}} extends Middleware
{
    public function beforeAction()
    {
        return true;
    }

    public function afterAction($result)
    {
        return $result;
    }
}
