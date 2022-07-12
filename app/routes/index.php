<?php

use App\DB;
use App\Controllers\Post;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

return function ($app) {
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

    $Db = new DB($connection);
    
    $app->get('/', function (Request $request, Response $response, $args) use ($view, $Db) {
        $posts = $Db->getList();

        $body = $view->render('index.twig', [
            'posts' => $posts
        ]);
        $response->getBody()->write($body);
        return $response;
    });

    $app->get('/post/{id}', function (Request $request, Response $response, $args) use ($view, $Db) {
        $post = $Db->getById((string) $args['id']);

        if (empty($post)) {
            $body = '404 not found';
        } else {
            $body = $view->render('post.twig', [
                'post' => $post
            ]);
        }
        $response->getBody()->write($body);
        return $response;
    });

    $app->get('/about', function (Request $request, Response $response, $args) {
        $response->getBody()->write("about page");
        return $response;
    });

    $app->get('/controller', [Post::class, 'post']);

    // Catch-all route to serve a 404 Not Found page if none of the routes match
    // NOTE: make sure this route is defined last
    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
        $response->getBody()->write("404 not found");
        return $response;
    });
};
