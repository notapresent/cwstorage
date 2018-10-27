<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use CWStorage\Application;
use function DI\create;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$containerBuilder = new ContainerBuilder();
$containerBuilder->useAutowiring(false);
$containerBuilder->useAnnotations(false);
$containerBuilder->addDefinitions([
    Application::class => create(Application::class)
]);

$container = $containerBuilder->build();

$app = $container->get(Application::class);
$app->announce();
