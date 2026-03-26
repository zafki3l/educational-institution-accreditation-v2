<?php

namespace App\Modules\UserProfile\Application\UseCases;

use App\Modules\UserManagement\Domain\ValueObjects\Password;
use App\Modules\UserProfile\Application\Requests\ChangePasswordRequestInterface;
use App\Modules\UserProfile\Domain\Events\PasswordChanged;
use App\Modules\UserProfile\Domain\Exceptions\NewPasswordNotMatchingException;
use App\Modules\UserProfile\Domain\Repositories\UserProfileRepositoryInterface;
use App\Modules\UserProfile\Domain\Services\VerifyCurrentPasswordInterface;
use App\Shared\Events\EventDispatcherInterface;

final class ChangePasswordUseCase
{
    public function __construct(
        private UserProfileRepositoryInterface $repository,
        private VerifyCurrentPasswordInterface $verifyCurrentPassword,
        private EventDispatcherInterface $eventDispatcher
    ) {}

    public function execute(ChangePasswordRequestInterface $request, string $actor_id): void
    {
        $this->verifyCurrentPassword->verify($request->getCurrentPassword(), $actor_id);

        if ($request->getNewPassword() !== $request->getNewPasswordConfirmation()) {
            throw new NewPasswordNotMatchingException();
        }

        $userProfile = $this->repository->getUserProfile($actor_id);

        $userProfile->changePassword(Password::fromPlain($request->getNewPassword())->value());

        $this->repository->changePassword($userProfile->getPassword(), $userProfile->getId());

        $this->eventDispatcher->dispatch(new PasswordChanged($actor_id));
    }
}