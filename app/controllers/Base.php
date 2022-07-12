<?php

namespace App\Controllers;

use App\DB;
use PDO;
use PDOException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Base
{

    public function __construct()
    {
        $loader = new FilesystemLoader('templates');
        $this->view = new Environment($loader);

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

        $this->Db = new DB($connection);
    }
}
