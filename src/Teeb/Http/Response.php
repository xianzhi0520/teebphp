<?php

namespace Teeb\Http;

use Teeb\Base\Application;

class Response
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function redirect($url)
    {
        header("Location: " . $url);

        exit;
    }

    public function refresh()
    {
        return $this->redirect($this->request->getUrl());
    }
}
