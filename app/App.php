<?php

namespace App;

use Fol;
use Relay\RelayBuilder;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\SapiStreamEmitter;
use Zend\Diactoros\Response;
use Psr7Middlewares\Middleware;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class App extends Fol
{
    /**
     * Run the app.
     */
    public static function run()
    {
        $app = new static();

        $request = ServerRequestFactory::fromGlobals();
        $response = $app->dispatch($request);

        (new SapiStreamEmitter())->emit($response);
    }

    /**
     * Init the app.
     */
    public function __construct()
    {
        $this->setPath(dirname(__DIR__));
        $this->setUrl(env('APP_URL'));

        $this->register(new Providers\Router());
        $this->register(new Providers\Templates());
        $this->register(new Providers\Galleries());
        $this->register(new Providers\Cache());
        $this->register(new Providers\Uploader());
    }

    public function getRoute($name, array $data = [], $query = null)
    {
        $query = $query ? '?'.http_build_query($query) : '';

        return $this->getUrl($this['router']->getGenerator()->generate($name, $data)).$query;
    }

    /**
     * Executes a request.
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function dispatch(ServerRequestInterface $request)
    {
        $dispatcher = (new RelayBuilder())->newInstance([
            Middleware::basePath($this->getUrlPath()),
            Middleware::trailingSlash(),
            Middleware::cache($this['cache']),
            Middleware::formatNegotiator(),
            Middleware::errorHandler(),
            Middleware::readResponse($this->getPath('data/uploads'))->continueOnError(),
            Middleware::AuraRouter($this['router'])->arguments($this)
        ]);

        return $dispatcher($request, new Response());
    }
}
