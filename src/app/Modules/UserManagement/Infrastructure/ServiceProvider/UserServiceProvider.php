<?php

namespace App\Modules\UserManagement\Infrastructure\ServiceProvider;

use App\Modules\UserManagement\Application\Readers\UserReaderInterface;
use App\Modules\UserManagement\Application\Requests\CreateUserRequestInterface;
use App\Modules\UserManagement\Application\Requests\UpdateUserRequestInterface;
use App\Modules\UserManagement\Domain\Repositories\UserRepositoryInterface;
use App\Modules\UserManagement\Domain\Services\EmailExistsCheckerInterface;
use App\Modules\UserManagement\Infrastructure\Readers\UserReader;
use App\Modules\UserManagement\Infrastructure\Repositories\UserRepository;
use App\Modules\UserManagement\Infrastructure\Services\EmailExistsChecker;
use App\Modules\UserManagement\Presentation\Requests\CreateUserRequest;
use App\Modules\UserManagement\Presentation\Requests\UpdateUserRequest;
use Core\ServiceProvider;
use Illuminate\Container\Container;

final class UserServiceProvider extends ServiceProvider
{
    public function register(Container $container): void
    {
        $container->bind(
            CreateUserRequestInterface::class,
            CreateUserRequest::class
        );

        $container->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $container->bind(
            UserReaderInterface::class,
            UserReader::class
        );

        $container->bind(
            UpdateUserRequestInterface::class,
            UpdateUserRequest::class
        );

        $container->bind(
            EmailExistsCheckerInterface::class,
            EmailExistsChecker::class
        );
    }
}