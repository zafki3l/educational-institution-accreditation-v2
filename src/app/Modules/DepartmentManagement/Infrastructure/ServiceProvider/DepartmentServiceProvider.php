<?php

namespace App\Modules\DepartmentManagement\Infrastructure\ServiceProvider;

use App\Modules\DepartmentManagement\Application\Requests\CreateDepartmentRequestInterface;
use App\Modules\DepartmentManagement\Application\Requests\UpdateDepartmentRequestInterface;
use App\Modules\DepartmentManagement\Domain\Repositories\DepartmentRepositoryInterface;
use App\Modules\DepartmentManagement\Infrastructure\Reader\DepartmentReader;
use App\Modules\DepartmentManagement\Infrastructure\Repositories\DepartmentRepository;
use App\Modules\DepartmentManagement\Presentation\Requests\CreateDepartmentRequest;
use App\Modules\DepartmentManagement\Presentation\Requests\UpdateDepartmentRequest;
use App\Shared\Application\Contracts\DepartmentReader\DepartmentReaderInterface;
use Core\ServiceProvider;
use Illuminate\Container\Container;

class DepartmentServiceProvider extends ServiceProvider
{
    public function register(Container $container): void
    {
        $container->bind(
            DepartmentReaderInterface::class,
            DepartmentReader::class
        );

        $container->bind(
            CreateDepartmentRequestInterface::class,
            CreateDepartmentRequest::class
        );

        $container->bind(
            UpdateDepartmentRequestInterface::class,
            UpdateDepartmentRequest::class
        );

        $container->bind(
            DepartmentRepositoryInterface::class,
            DepartmentRepository::class
        );
    }
}