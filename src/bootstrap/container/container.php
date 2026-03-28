<?php

use App\Shared\Contracts\Events\EventDispatcherInterface;
use App\Shared\Contracts\Logging\LoggerInterface;
use App\Shared\Infrastructure\Events\EventDispatcher;
use App\Shared\Infrastructure\Logging\MongoLogger;
use App\Shared\Infrastructure\Persistence\MySQLDatabase;
use Core\App;
use Illuminate\Container\Container;

$container = new Container();

$container->singleton(\PDO::class, function () {
    return (new MySQLDatabase())->connect();
});

$container->bind(
    LoggerInterface::class,
    MongoLogger::class
);

$providers = require_once 'providers.php';

foreach ($providers as $provider) {
    $provider->register($container);
}

$dispatcher = new EventDispatcher();

$eventConfig = require 'events.php';
foreach ($eventConfig as $eventClass => $listeners) {
    foreach ($listeners as $listenerClass) {
        $dispatcher->addListener($eventClass, function($event) use ($container, $listenerClass) {
            $handler = $container->get($listenerClass);
            $handler->handle($event);
        });
    }
}

$container->instance(EventDispatcherInterface::class, $dispatcher);

App::setContainer($container);