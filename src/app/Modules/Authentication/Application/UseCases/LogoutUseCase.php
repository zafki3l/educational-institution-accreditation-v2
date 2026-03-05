<?php

namespace App\Modules\Authentication\Application\UseCases;

use App\Shared\SessionManager\AuthSession;

final class LogoutUseCase
{
    public function __construct(private AuthSession $session) {}

    public function execute(): void
    {
        $this->session->clear();
    }
}