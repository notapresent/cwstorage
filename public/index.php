<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use CWStorage\Application;
use Relay\Relay;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\SapiEmitter;
use FastRoute\RouteCollector;
use Middlewares\FastRoute;
use Middlewares\RequestHandler;
use function DI\create;
use function DI\get;
use function FastRoute\simpleDispatcher;


require_once dirname(__DIR__) . '/vendor/autoload.php';

$containerBuilder = new ContainerBuilder();
$containerBuilder->useAutowiring(false);
$containerBuilder->useAnnotations(false);
$containerBuilder->addDefinitions([
    Application::class => create(Application::class)
        ->constructor(get('Response')),
    'Response' => function() {
        return new Response();
    },
]);

$container = $containerBuilder->build();

$middlewareQueue = [];

$routes = simpleDispatcher(function (RouteCollector $r) {
    $r->get('/', Application::class);
});

$middlewareQueue[] = new FastRoute($routes);
$middlewareQueue[] = new RequestHandler($container);

$requestHandler = new Relay($middlewareQueue);
$response = $requestHandler->handle(ServerRequestFactory::fromGlobals());


$emitter = new SapiEmitter();
$emitter->emit($response);
