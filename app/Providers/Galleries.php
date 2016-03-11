<?php

namespace App\Providers;

use Fol;
use Fol\ServiceProviderInterface;
use App\Models\Galleries as GalleriesModel;
use League\Flysystem\Adapter\Local;

class Galleries implements ServiceProviderInterface
{
    public function register(Fol $app)
    {
        $app['galleries'] = function ($app) {
            return new GalleriesModel(new Local($app->getPath('data/uploads/images')));
        };
    }
}
