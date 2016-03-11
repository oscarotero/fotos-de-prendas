<?php

namespace App\Providers;

use Fol;
use Fol\ServiceProviderInterface;
use App\Models\Galleries;
use League\Flysystem\Adapter\Local;

class Galleries implements ServiceProviderInterface
{
    public function register(Fol $app)
    {
        $app['galleries'] = function ($app) {
            return new Galleries(new Local($app->getPath('data/uploads/images')));
        };
    }
}