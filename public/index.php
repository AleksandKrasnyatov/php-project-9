<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Url;
use App\UrlRepository;
use App\UrlValidator;
use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Flash\Messages;
use Slim\Middleware\MethodOverrideMiddleware;
use Slim\Views\PhpRenderer;

// Старт PHP сессии
session_start();


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

$initFilePath = implode('/', [dirname(__DIR__), 'database.sql']);
$initSql = file_get_contents($initFilePath);
$container->get(\PDO::class)->exec($initSql);

$app = AppFactory::createFromContainer($container);

$router = $app->getRouteCollector()->getRouteParser();

$app->addErrorMiddleware(true, true, true);
$app->add(MethodOverrideMiddleware::class);

$app->get('/', function ($request, $response) {
    $params = [
        'url' => new Url(),
        'errors' => []
    ];
    return  $this->get('renderer')->render($response, "index.php", $params);
})->setName('home');

$app->get('/urls', function ($request, $response) {
    $urlRepository = $this->get(UrlRepository::class);
    $urls = $urlRepository->getEntities();

    $params = [
        'urls' => $urls,
    ];

    return $this->get('renderer')->render($response, 'list.php', $params);
})->setName('urls.index');

$app->get('/urls/{id}', function ($request, $response, $args) use ($router) {
    $id = $args['id'];
    $urlRepository = $this->get(UrlRepository::class);
    $url = $urlRepository->find($id);

    if (is_null($url)) {
        return $response->write('Page not found')->withStatus(404);
    }
    $messages = $this->get('flash')->getMessages();

    $params = [
        'url' => $url,
        'checks' => [],
        'flash' => $messages ?? []
    ];

    return $this->get('renderer')->render($response, 'url.php', $params);
})->setName('urls.show');

$app->post('/urls', function ($request, $response, $args) use ($router) {
    $urlRepository = $this->get(UrlRepository::class);
    $urlData = $request->getParsedBodyParam('url');
    $validator = new UrlValidator();
    $errors = $validator->validate($urlData);

    if (count($errors) === 0) {
        if ($url = $urlRepository->findByName($urlData['name'])) {
            $this->get('flash')->addMessage('success', 'Url is already exists');
        } else {
            $url = Url::create($urlData['name'], date("Y-m-d H:i:s"));
            $urlRepository->save($url);
            $this->get('flash')->addMessage('success', 'Url was added successfully');
        }
        return $response->withRedirect($router->urlFor('urls.show', ['id' => $url->getId()]));
    }

    $params = [
        'url' => Url::create($urlData['name']),
        'errors' => $errors
    ];

    return $this->get('renderer')->render($response->withStatus(422), 'index.php', $params);
})->setName('urls.store');

$app->run();
