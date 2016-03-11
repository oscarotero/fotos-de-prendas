<?php

namespace App\Providers;

use Fol;
use Fol\ServiceProviderInterface;
use Aura\Router\RouterContainer;

class Router implements ServiceProviderInterface
{
    public function register(Fol $app)
    {
        $app['router'] = function ($app) {
            //Namespace dos controladores
            $ns = $app->getNamespace('Controllers');

            //Xeramos a ruta collendo a url base
            $router = new RouterContainer();

            //Mapeamos todas as rutas
            $map = $router->getMap();

            $map->get('index', '/', "{$ns}\\Index::index");
            $map->get('galeria', '/galeria/{galeria}', "{$ns}\\Index::galeria");

            $map->post('nova-galeria', '/nova-galeria', "{$ns}\\Index::novaGaleria");
            $map->post('subir-foto', '/subir-foto', "{$ns}\\Index::subirFoto");
            $map->post('xirar-foto', '/xirar-foto', "{$ns}\\Index::xirarFoto");
            $map->post('eliminar-foto', '/eliminar-foto', "{$ns}\\Index::eliminarFoto");

            return $router;
        };
    }
}
