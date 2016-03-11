<?php

namespace App\Providers;

use Fol;
use Fol\ServiceProviderInterface;
use League\Flysystem;
use MatthiasMullie\Scrapbook;

class Cache implements ServiceProviderInterface
{
    public function register(Fol $app)
    {
        $app['cache'] = function ($app) {
            $adapter = new Flysystem\Adapter\Local($app->getPath('data/cache'), LOCK_EX);
            $filesystem = new Flysystem\Filesystem($adapter);
            $cache = new Scrapbook\Adapters\Flysystem($filesystem);

            return new Scrapbook\Psr6\Pool($cache);
        };
    }
}
