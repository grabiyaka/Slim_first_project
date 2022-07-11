<?php

declare(strict_types=1);

namespace App;

use PDO;

class DB
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getById(string $id) : ?array
    {
        $statemen = $this->connection->prepare("SELECT * FROM post WHERE id = :id");
        $statemen->execute([
            'id' => $id
        ]);

        $result = $statemen->fetchAll();

        return array_shift($result);
    }

    public function getList() : ?array
    {
        $statemen = $this->connection->prepare("SELECT * FROM post");

        $statemen->execute();

        return $statemen->fetchAll();
    }
}