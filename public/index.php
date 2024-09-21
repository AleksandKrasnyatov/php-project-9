<?php

require __DIR__ . '/../vendor/autoload.php';

use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;

$container = new Container();
$container->set('renderer', function () {
    $renderer = new PhpRenderer(__DIR__ . '/../templates');
    $renderer->setLayout('layout.php');
    return $renderer;
});

$app = AppFactory::createFromContainer($container);

$app->addErrorMiddleware(true, true, true);

$app->get('/', function ($request, $response) {
    return  $this->get('renderer')->render($response, "index.php");
});

$app->post('/urls', function ($request, $response, $args) {
    //logic
    return  $this->get('renderer')->render($response, "index.php");
});

$app->run();
