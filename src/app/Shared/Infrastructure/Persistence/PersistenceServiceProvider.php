<?php

namespace App\Shared\Infrastructure\Persistence;

use App\Shared\Contracts\Logging\LoggerInterface;
use App\Shared\Contracts\UnitOfWork\UnitOfWorkInterface;
use App\Shared\Infrastructure\Logging\MongoLogger;
use Core\ServiceProvider;
use Illuminate\Container\Container;

final class PersistenceServiceProvider extends ServiceProvider
{
    public function register(Container $container): void
    {
        $container->singleton(\PDO::class, function () {
            return (new MySQLDatabase())->connect();
        });

        $container->bind(
            LoggerInterface::class,
            MongoLogger::class
        );

        $container->singleton(\Illuminate\Database\ConnectionInterface::class, function () {
            return \Illuminate\Database\Capsule\Manager::connection();
        });

        $container->bind(
            UnitOfWorkInterface::class,
            UnitOfWork::class
        );
    }
}