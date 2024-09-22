<?php

require __DIR__ . '/../vendor/autoload.php';

use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Flash\Messages;
use Slim\Views\PhpRenderer;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

$container = new Container();

$container->set('renderer', function () {
    $renderer = new PhpRenderer(__DIR__ . '/../templates');
    $renderer->setLayout('layout.php');
    return $renderer;
});

$container->set('flash', function () {
    return new Messages();
});

$container->set(\PDO::class, function () {
    $databaseUrl = parse_url($_ENV['DATABASE_URL']);
    $conStr = sprintf(
        "pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s",
        $databaseUrl['host'],
        $databaseUrl['port'],
        ltrim($databaseUrl['path'], '/'),
        $databaseUrl['user'],
        $databaseUrl['pass']
    );

    $conn = new \PDO($conStr);
    $conn->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
    return $conn;
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
