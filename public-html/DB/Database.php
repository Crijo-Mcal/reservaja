<?php

namespace public\DB;

use PDO;

class Database
{
    public static function connection(): PDO
    {
        $dsn = "mysql:host={$_ENV['DB_HOST']};"
            . "port={$_ENV['DB_PORT']};"
            . "dbname={$_ENV['DB_DATABASE']};"
            . "charset=utf8mb4";

        $pdo = new PDO(
            $dsn,
            $_ENV['DB_USERNAME'],
            $_ENV['DB_PASSWORD']
        );

        $pdo->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );

        $pdo->setAttribute(
            PDO::ATTR_DEFAULT_FETCH_MODE,
            PDO::FETCH_ASSOC
        );

        return $pdo;
    }
}