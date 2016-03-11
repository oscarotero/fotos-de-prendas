<?php

namespace App\Providers;

use Fol;
use Fol\ServiceProviderInterface;
use Uploader\Uploader;

class Uploader implements ServiceProviderInterface
{
    public function register(Fol $app)
    {
        $app['uploader'] = function ($app) {
            return new Uploader($app->getPath('data/uploads/images'));
        };
    }
}