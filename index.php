<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;
use Slim\Factory\AppFactory;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require __DIR__ . '/vendor/autoload.php';

$loader = new FilesystemLoader('templates');
$view = new Environment($loader);

$config = include 'config/database.php';
$dsn = $config['dsn'];
$username = $config['username'];
$password = $config['password'];

try {
    $connection = new PDO($dsn, $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $exception) {
    echo 'DB error ' . $exception->getMessage();
    die();
}

$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response, $args) use ($view) {
    $body = $view->render('index.twig');
    $response->getBody()->write($body);
    return $response;
});

$app->get('/page/{key}', function (Request $request, Response $response, $args) use ($view) {
    $body = $view->render('page.twig', [
        'key' => $args['key']
    ]);
    $response->getBody()->write($body);
    return $response;
});

$app->get('/about', function (Request $request, Response $response, $args) {
    $response->getBody()->write("about page");
    return $response;
});

// Catch-all route to serve a 404 Not Found page if none of the routes match
// NOTE: make sure this route is defined last
$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
    $response->getBody()->write("404 not found");
    return $response;
});

$app->run();
