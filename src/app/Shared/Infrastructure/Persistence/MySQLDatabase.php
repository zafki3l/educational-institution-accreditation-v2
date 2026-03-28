<?php

namespace App\Shared\Infrastructure\Persistence;

use PDO;
use PDOException;

class MySQLDatabase
{
    public function connect(): PDO
    {
        try {
            $dsn = "mysql:host={$_ENV['MYSQL_HOST']};dbname={$_ENV['MYSQL_DATABASE']};charset=UTF8";
            
            return new PDO($dsn, $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASSWORD']);
        } catch (PDOException $e) {
            throw $e;
        }
    }
}