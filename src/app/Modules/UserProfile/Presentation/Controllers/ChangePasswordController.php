<?php

namespace App\Modules\UserProfile\Presentation\Controllers;

use App\Modules\UserProfile\Application\UseCases\ChangePasswordUseCase;
use App\Modules\UserProfile\Presentation\Requests\ChangePasswordRequest;
use App\Shared\Domain\Exception\DomainException;
use App\Shared\Security\Session\AuthSession;

final class ChangePasswordController extends UserProfileController
{
    public function __construct(private ChangePasswordUseCase $changePasswordUseCase) {}

    public function change(ChangePasswordRequest $request): void
    {
        try {
            $this->changePasswordUseCase->execute($request, AuthSession::getUserId());

        $this->redirect('/profile');
        } catch (DomainException $e) {
            $_SESSION['pwd-errors'] = [$e->getMessage()];
            
            $this->redirect('/profile');
        }
    }
}