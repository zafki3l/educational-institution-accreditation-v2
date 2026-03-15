<?php

namespace App\Modules\Authorization\Infrastructure\ServiceProvider;

use App\Modules\Authorization\Application\Role\Requests\CreateRoleRequestInterface;
use App\Modules\Authorization\Application\Role\Requests\UpdateRoleRequestInterface;
use App\Modules\Authorization\Domain\Repositories\RoleRepositoryInterface;
use App\Modules\Authorization\Infrastructure\Readers\RoleReader;
use App\Modules\Authorization\Infrastructure\Repositories\RoleRepository;
use App\Modules\Authorization\Presentation\Requests\Role\CreateRoleRequest;
use App\Modules\Authorization\Presentation\Requests\Role\UpdateRoleRequest;
use App\Shared\Application\Contracts\RoleReader\RoleReaderInterface;
use Core\ServiceProvider;
use Illuminate\Container\Container;

final class RoleServiceProvider extends ServiceProvider
{
    public function register(Container $container): void
    {
        $container->bind(
            CreateRoleRequestInterface::class, 
            CreateRoleRequest::class
        );

        $container->bind(
            UpdateRoleRequestInterface::class,
            UpdateRoleRequest::class
        );

        $container->bind(
            RoleRepositoryInterface::class,
            RoleRepository::class
        );

        $container->bind(
            RoleReaderInterface::class,
            RoleReader::class
        );
    }
}