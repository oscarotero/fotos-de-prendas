<?php

namespace App\Providers;

use Fol;
use Fol\ServiceProviderInterface;
use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class Templates implements ServiceProviderInterface
{
    public function register(Fol $app)
    {
        $app['templates'] = function ($app) {
            $engine = new Engine($app->getPath('templates'));

            $engine->addData(['app' => $app]);

            return $engine;
        };
    }
}