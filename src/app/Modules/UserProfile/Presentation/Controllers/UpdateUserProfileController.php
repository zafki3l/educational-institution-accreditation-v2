<?php

namespace App\Modules\UserProfile\Presentation\Controllers;

use App\Modules\UserProfile\Application\UseCases\UpdateUserProfileUseCase;
use App\Modules\UserProfile\Presentation\Requests\UpdateUserProfileRequest;
use App\Shared\Domain\Exception\DomainException;
use App\Shared\SessionManager\AuthSession;

final class UpdateUserProfileController extends UserProfileController
{
    public function __construct(private UpdateUserProfileUseCase $updateUserProfileUseCase) {}

    public function update(UpdateUserProfileRequest $request): void
    {
        try {
            $this->updateUserProfileUseCase->execute($request, AuthSession::getUserId());

            $this->redirect('/profile');
        } catch (DomainException $e) {
            $_SESSION['errors'] = [$e->getMessage()];
            
            $this->redirect('/profile');
        }
    }
}