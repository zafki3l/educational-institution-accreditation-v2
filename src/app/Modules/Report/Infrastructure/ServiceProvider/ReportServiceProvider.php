<?php

namespace App\Modules\Report\Infrastructure\ServiceProvider;

use App\Modules\Report\Application\Readers\ReportReaderInterface;
use App\Modules\Report\Infrastructure\Readers\ReportReader;
use Core\ServiceProvider;
use Illuminate\Container\Container;

final class ReportServiceProvider extends ServiceProvider
{
    public function register(Container $container): void
    {
        $container->bind(
            ReportReaderInterface::class,
            ReportReader::class
        );
    }
}