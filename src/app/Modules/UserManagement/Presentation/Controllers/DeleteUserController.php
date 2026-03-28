<?php

namespace App\Modules\UserManagement\Presentation\Controllers;

use App\Modules\UserManagement\Application\UseCases\DeleteUserUseCase;
use App\Shared\Security\Session\AuthSession;

final class DeleteUserController extends UserController
{
    public function __construct(
        private DeleteUserUseCase $deleteUserUseCase,
        private AuthSession $authSession
    ) {}

    public function destroy(string $id)
    {
        $this->deleteUserUseCase->execute($id, $this->authSession->authUser()->user_id);
        
        $this->redirect('/users');
    }
}