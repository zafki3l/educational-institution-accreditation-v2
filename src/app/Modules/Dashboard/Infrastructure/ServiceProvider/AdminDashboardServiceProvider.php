<?php

namespace App\Modules\Dashboard\Infrastructure\ServiceProvider;

use App\Modules\Dashboard\Application\Readers\AdminDashboardReaderInterface;
use App\Modules\Dashboard\Infrastructure\Readers\AdminDashboardReader;
use Core\ServiceProvider;
use Illuminate\Container\Container;

final class AdminDashboardServiceProvider extends ServiceProvider
{
    public function register(Container $container): void
    {
        $container->bind(
            AdminDashboardReaderInterface::class,
            AdminDashboardReader::class
        );
    }
}