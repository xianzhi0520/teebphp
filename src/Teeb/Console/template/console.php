<?php

namespace App\Console;

use Teeb\Console\Controller;
use Teeb\Console\Request;

class {{controller}} extends Controller
{
    public function actionIndex(Request $request)
    {
        return "This is index action.\n";
    }
}
