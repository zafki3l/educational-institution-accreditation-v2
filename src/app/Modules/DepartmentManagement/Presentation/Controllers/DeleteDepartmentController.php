<?php

namespace App\Modules\DepartmentManagement\Presentation\Controllers;

use App\Modules\DepartmentManagement\Application\UseCases\DeleteDepartmentUseCase;
use App\Shared\Security\Session\AuthSession;

final class DeleteDepartmentController extends DepartmentController
{
    public function __construct(
        private DeleteDepartmentUseCase $deleteDepartmentUseCase,
        private AuthSession $authSession
    ) {}

    public function destroy(string $id): void
    {
        $this->deleteDepartmentUseCase->execute($id, $this->authSession->authUser()->user_id);

        $this->redirect('/departments?success=delete');
    }
}