<?php

namespace App\Providers;

use Fol;
use Fol\ServiceProviderInterface;
use Uploader\Uploader as UploaderLib;

class Uploader implements ServiceProviderInterface
{
    public function register(Fol $app)
    {
        $app['uploader'] = function ($app) {
            return new UploaderLib($app->getPath('data/uploads/images'));
        };
    }
}
