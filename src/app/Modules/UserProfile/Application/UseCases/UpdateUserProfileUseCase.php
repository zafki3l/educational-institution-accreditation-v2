<?php

namespace App\Modules\UserProfile\Application\UseCases;

use App\Modules\UserProfile\Application\Requests\UpdateUserProfileRequestInterface;
use App\Modules\UserProfile\Domain\Entities\UserProfile;
use App\Modules\UserProfile\Domain\Exceptions\EmailExistException;
use App\Modules\UserProfile\Domain\Repositories\UserProfileRepositoryInterface;
use App\Modules\UserProfile\Domain\Services\EmailExistsCheckerInterface;
use App\Shared\Logging\LoggerInterface;

final class UpdateUserProfileUseCase
{
    public function __construct(
        private UserProfileRepositoryInterface $repository,
        private EmailExistsCheckerInterface $emailExistsChecker,
        private LoggerInterface $logger
    ) {}

    public function execute(UpdateUserProfileRequestInterface $request, string $actor_id): void
    {
        $userProfile = UserProfile::create(
            $actor_id, 
            $request->getFirstName(), 
            $request->getLastName()
        );

        $fromDb = $this->repository->getUserProfile($userProfile->getId());

        $this->updateEmail($userProfile, $request->getEmail(), $fromDb->getEmail());

        $updatedUserProfile = $this->repository->update($userProfile);

        $this->writeLog($updatedUserProfile, $fromDb, $actor_id);
    }

    private function updateEmail(UserProfile $userProfile, string $email, ?string $email_from_db): void
    {
        if ($email !== '' && $email !== $email_from_db) {
            if ($this->emailExistsChecker->isExists($email)) {
                throw new EmailExistException();
            }

            $userProfile->updateEmail($email);
        }
    }

    private function writeLog(UserProfile $updatedUserProfile, UserProfile $fromDb, string $actor_id): void
    {
        $this->logger->write(
            'info',
            'update', 
            "Người dùng {$actor_id} đã cập nhật hồ sơ cá nhân của người dùng {$updatedUserProfile->getId()}",
            $actor_id,
            [
                'id' => $updatedUserProfile->getId(),
                'old_first_name' => $fromDb->getFirstName(),
                'new_first_name' => $updatedUserProfile->getFirstName(),
                'old_last_name' => $fromDb->getLastName(),
                'new_last_name' => $updatedUserProfile->getLastName(),
                'old_email' => $fromDb->getEmail() ? $fromDb->getEmail() : '',
                'new_email' => $updatedUserProfile->getEmail() 
                                    ? $updatedUserProfile->getEmail() 
                                    : ($fromDb->getEmail() 
                                        ? $fromDb->getEmail() 
                                        : '')
            ]
        );
    }
}