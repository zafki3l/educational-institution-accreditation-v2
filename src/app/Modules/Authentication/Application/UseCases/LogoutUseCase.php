<?php

namespace App\Modules\Authentication\Application\UseCases;

use App\Modules\Authentication\Domain\Events\UserLoggedOut;
use App\Shared\Events\EventDispatcherInterface;
use App\Shared\SessionManager\AuthSession;

final class LogoutUseCase
{
    public function __construct(
        private AuthSession $session,
        private EventDispatcherInterface $eventDispatcher
    ) {}

    public function execute(): void
    {
        $authUser = $this->session->authUser();

        if ($authUser) {
            $this->eventDispatcher->dispatch(new UserLoggedOut($authUser->user_id));

            $this->session->clear();
        }
    }
}