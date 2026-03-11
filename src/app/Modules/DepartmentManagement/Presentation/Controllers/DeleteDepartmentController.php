<?php

namespace App\Modules\DepartmentManagement\Presentation\Controllers;

use App\Modules\DepartmentManagement\Application\UseCases\DeleteDepartmentUseCase;
use App\Shared\SessionManager\AuthSession;

final class DeleteDepartmentController extends DepartmentController
{
    public function __construct(private DeleteDepartmentUseCase $deleteDepartmentUseCase) {}

    public function destroy(string $id): void
    {
        $this->deleteDepartmentUseCase->execute($id, AuthSession::getUserId());

        $this->redirect('/departments?success=delete');
    }
}