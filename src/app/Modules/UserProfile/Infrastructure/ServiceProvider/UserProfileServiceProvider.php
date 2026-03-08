<?php

namespace App\Modules\UserProfile\Infrastructure\ServiceProvider;

use App\Modules\UserProfile\Application\Requests\ChangePasswordRequestInterface;
use App\Modules\UserProfile\Application\Requests\UpdateUserProfileRequestInterface;
use App\Modules\UserProfile\Domain\Repositories\UserProfileRepositoryInterface;
use App\Modules\UserProfile\Domain\Services\EmailExistsCheckerInterface;
use App\Modules\UserProfile\Domain\Services\VerifyCurrentPasswordInterface;
use App\Modules\UserProfile\Infrastructure\Repositories\UserProfileRepository;
use App\Modules\UserProfile\Infrastructure\Services\EmailExistsChecker;
use App\Modules\UserProfile\Infrastructure\Services\VerifyCurrentPassword;
use App\Modules\UserProfile\Presentation\Requests\ChangePasswordRequest;
use App\Modules\UserProfile\Presentation\Requests\UpdateUserProfileRequest;
use Core\ServiceProvider;
use Illuminate\Container\Container;

final class UserProfileServiceProvider extends ServiceProvider
{
    public function register(Container $container): void
    {
        $container->bind(
            UpdateUserProfileRequestInterface::class,
            UpdateUserProfileRequest::class
        );

        $container->bind(
            UserProfileRepositoryInterface::class,
            UserProfileRepository::class
        );

        $container->bind(
            EmailExistsCheckerInterface::class,
            EmailExistsChecker::class
        );

        $container->bind(
            ChangePasswordRequestInterface::class,
            ChangePasswordRequest::class
        );

        $container->bind(
            VerifyCurrentPasswordInterface::class,
            VerifyCurrentPassword::class
        );
    }
}