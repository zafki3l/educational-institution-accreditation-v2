<?php

namespace App\Modules\DepartmentManagement\Presentation\Controllers;

use App\Modules\DepartmentManagement\Application\UseCases\CreateDepartmentUseCase;
use App\Modules\DepartmentManagement\Presentation\Requests\CreateDepartmentRequest;
use App\Shared\SessionManager\AuthSession;

final class CreateDepartmentController extends DepartmentController
{
    public function __construct(private CreateDepartmentUseCase $createDepartmentUseCase) {}

    public function store(CreateDepartmentRequest $request): void
    {
        $this->createDepartmentUseCase->execute($request, AuthSession::getUserId());

        $this->redirect('/departments?success=create');
    }
}