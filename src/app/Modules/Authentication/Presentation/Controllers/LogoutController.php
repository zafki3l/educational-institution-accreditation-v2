<?php

namespace App\Modules\Authentication\Presentation\Controllers;

use App\Modules\Authentication\Application\UseCases\LogoutUseCase;

final class LogoutController extends AuthController
{
    public function __construct(private LogoutUseCase $logoutUseCase) {}

    public function logout(): void
    {
        $this->logoutUseCase->execute();

        $this->redirect('/login');
    }
}
