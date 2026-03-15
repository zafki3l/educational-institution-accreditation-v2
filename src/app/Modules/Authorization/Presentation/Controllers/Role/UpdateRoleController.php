<?php

namespace App\Modules\Authorization\Presentation\Controllers\Role;

use App\Modules\Authorization\Application\Role\UseCases\UpdateRoleUseCase;
use App\Modules\Authorization\Presentation\Controllers\AuthorizationController;
use App\Modules\Authorization\Presentation\Requests\Role\UpdateRoleRequest;
use App\Shared\Exception\DomainException;
use App\Shared\Response\JsonResponse;
use App\Shared\SessionManager\AuthSession;

final class UpdateRoleController extends AuthorizationController
{
    public function __construct(private UpdateRoleUseCase $updateRoleUseCase) {}

    public function update(UpdateRoleRequest $request): JsonResponse
    {
        try {
            $this->updateRoleUseCase->execute($request, AuthSession::getUserId());

            return new JsonResponse([]);
        } catch (DomainException $e) {
            return new JsonResponse([
                'errors' => [$e->getMessage()],
            ], 422);
        }
    }
}
