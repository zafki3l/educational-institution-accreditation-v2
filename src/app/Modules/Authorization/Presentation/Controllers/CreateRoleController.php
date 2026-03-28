<?php

namespace App\Modules\Authorization\Presentation\Controllers;

use App\Modules\Authorization\Application\UseCases\CreateRoleUseCase;
use App\Modules\Authorization\Presentation\Controllers\AuthorizationController;
use App\Modules\Authorization\Presentation\Requests\CreateRoleRequest;
use App\Shared\Security\Session\AuthSession;

final class CreateRoleController extends AuthorizationController
{
    public function __construct(
        private CreateRoleUseCase $createRoleUseCase,
        private AuthSession $authSession
    ) {}

    public function store(CreateRoleRequest $request): void
    {        
        $this->createRoleUseCase->execute($request, $this->authSession->authUser()->user_id);

        $this->redirect(ROOT_URL . '/roles?success=create');
    }
}