<?php

namespace App\Modules\Authorization\Presentation\Controllers\Role;

use App\Modules\Authorization\Application\Role\UseCases\CreateRoleUseCase;
use App\Modules\Authorization\Presentation\Controllers\AuthorizationController;
use App\Modules\Authorization\Presentation\Requests\Role\CreateRoleRequest;
use App\Shared\SessionManager\AuthSession;

final class CreateRoleController extends AuthorizationController
{
    public function __construct(private CreateRoleUseCase $createRoleUseCase) {}

    public function store(CreateRoleRequest $request): void
    {        
        $this->createRoleUseCase->execute($request, AuthSession::getUserId());

        $this->redirect(ROOT_URL . '/roles?success=create');
    }
}