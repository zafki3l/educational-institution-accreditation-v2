<?php

namespace App\Modules\UserProfile\Application\UseCases;

use App\Modules\UserManagement\Domain\ValueObjects\Password;
use App\Modules\UserProfile\Application\Requests\ChangePasswordRequestInterface;
use App\Modules\UserProfile\Domain\Entities\UserProfile;
use App\Modules\UserProfile\Domain\Exceptions\NewPasswordNotMatchingException;
use App\Modules\UserProfile\Domain\Repositories\UserProfileRepositoryInterface;
use App\Modules\UserProfile\Domain\Services\VerifyCurrentPasswordInterface;
use App\Shared\Logging\LoggerInterface;

final class ChangePasswordUseCase
{
    public function __construct(
        private UserProfileRepositoryInterface $repository,
        private LoggerInterface $logger,
        private VerifyCurrentPasswordInterface $verifyCurrentPassword
    ) {}

    public function execute(ChangePasswordRequestInterface $request, string $actor_id)
    {
        $this->verifyCurrentPassword->verify($request->getCurrentPassword(), $actor_id);

        if ($request->getNewPassword() !== $request->getNewPasswordConfirmation()) {
            throw new NewPasswordNotMatchingException();
        }

        $userProfile = $this->repository->getUserProfile($actor_id);

        $userProfile->changePassword(Password::fromPlain($request->getNewPassword())->value());

        $updated = $this->repository->changePassword($userProfile->getPassword(), $userProfile->getId());

        $this->writeLog($updated, $actor_id);
    }

    private function writeLog(UserProfile $updated, string $actor_id): void
    {
        $this->logger->write(
            'info',
            'update', 
            "Người dùng {$actor_id} đã thay đổi mật khẩu của mình",
            $actor_id,
            [
                'id' => $updated->getId(),
                'first_name' => $updated->getFirstName(),
                'last_name' => $updated->getLastName()
            ]
        );
    }
}