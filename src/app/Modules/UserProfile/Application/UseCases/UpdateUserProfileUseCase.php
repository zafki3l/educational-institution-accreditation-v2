<?php

namespace App\Modules\UserProfile\Application\UseCases;

use App\Modules\UserProfile\Application\Requests\UpdateUserProfileRequestInterface;
use App\Modules\UserProfile\Domain\Entities\UserProfile;
use App\Modules\UserProfile\Domain\Events\UserProfileUpdated;
use App\Modules\UserProfile\Domain\Exceptions\EmailExistException;
use App\Modules\UserProfile\Domain\Repositories\UserProfileRepositoryInterface;
use App\Modules\UserProfile\Domain\Services\EmailExistsCheckerInterface;
use App\Shared\Events\EventDispatcherInterface;

final class UpdateUserProfileUseCase
{
    public function __construct(
        private UserProfileRepositoryInterface $repository,
        private EmailExistsCheckerInterface $emailExistsChecker,
        private EventDispatcherInterface $eventDispatcher
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

        $this->eventDispatcher->dispatch(new UserProfileUpdated(
            $actor_id,
            $fromDb->getFirstName(),
            $updatedUserProfile->getFirstName(),
            $fromDb->getLastName(),
            $updatedUserProfile->getLastName(),
            $fromDb->getEmail() ? $fromDb->getEmail() : '',
            $updatedUserProfile->getEmail() 
                ? $updatedUserProfile->getEmail() 
                : ($fromDb->getEmail() 
                    ? $fromDb->getEmail() 
                    : '')
        ));
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
}