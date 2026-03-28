<?php

namespace App\Modules\Authorization\Presentation\Controllers;

use App\Modules\Authorization\Application\UseCases\DeleteRoleUseCase;
use App\Modules\Authorization\Presentation\Controllers\AuthorizationController;
use App\Shared\Security\Session\AuthSession;

final class DeleteRoleController extends AuthorizationController
{
    public function __construct(
        private DeleteRoleUseCase $deleteRoleUseCase,
        private AuthSession $authSession
    ) {}

    public function destroy(int $id): void
    {
        $this->deleteRoleUseCase->execute($id, $this->authSession->authUser()->user_id);

        $this->redirect(ROOT_URL . '/roles');
    }
}