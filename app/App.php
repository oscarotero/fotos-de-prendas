<?php
namespace App;

use Fol\Config;
use Fol\Templates;
use Fol\Errors;

use Fol\Http\Request;
use Fol\Http\Router\Router;
use Fol\Http\Router\RouteFactory;

use Fol\FileSystem;

class App extends \Fol\App
{
    /**
     * Run the app (from http context)
     */
    public static function run ()
    {
        //Configure errors
        Errors::register();
        Errors::displayErrors();
        Errors::setPhpLogFile(BASE_PATH.'/logs/php.log');

        //Execute the app
        $app = new static();
        $request = Request::createFromGlobals();

        $app($request)->send();
    }


    /**
     * Contructor. Register all services, etc
     */
    public function __construct()
    {
        //Init config
        $this->config = new Config($this->getPath('config'));

        //Init router
        $this->router = new Router(new RouteFactory($this->getNamespace('Controllers')));

        $this->router->map([
            'index' => [
                'path' => '/',
                'target' => 'Index::index'
            ],
            'nova-galeria' => [
                'path' => '/nova-galeria',
                'target' => 'Index::novaGaleria',
                'method' => 'POST'
            ],
            'galeria' => [
                'path' => '/galeria/{galeria}',
                'target' => 'Index::galeria'
            ],
            'subir-foto' => [
                'path' => '/subir-foto',
                'target' => 'Index::subirFoto',
                'method' => 'POST'
            ],
            'xirar-foto' => [
                'path' => '/xirar-foto',
                'target' => 'Index::xirarFoto',
                'method' => 'POST'
            ],
            'eliminar-foto' => [
                'path' => '/eliminar-foto',
                'target' => 'Index::eliminarFoto',
                'method' => 'POST'
            ]
        ]);

        //$this->router->setError('Index::error');

        //Register other services
        $this->define([
            'templates' => function () {
                $templates = new Templates($this->getPath('templates'));
                $templates->app = $this;

                return $templates;
            },
            'galleries' => function () {
                return new Models\Galleries(new FileSystem($this->getPath('../public/fotos')));
            }
        ]);
    }


    /**
     * Executes a request
     *
     * @param \Fol\Http\Request $request
     * 
     * @return \Fol\Http\Response
     */
    protected function handleRequest(Request $request)
    {
        return $this->router->handle($request, [$this]);
    }
}
