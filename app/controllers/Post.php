<?php

namespace App\Controllers;

use App\DB;
use PDO;
use PDOException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Environment;
use Twig\Loader\FilesystemLoader;
use App\Controllers\Base;
use App\Models\Post as PostModel;

class Post extends Base
{
    public function post(Request $request, Response $response)
    {
        $message = PostModel::post();
        $response->getBody()->write($message);
        return $response;
    }
}
