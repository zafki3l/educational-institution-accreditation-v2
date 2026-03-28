<?php

namespace App\Modules\Authorization\Presentation\Controllers;

use App\Modules\Authorization\Application\UseCases\UpdateRoleUseCase;
use App\Modules\Authorization\Presentation\Controllers\AuthorizationController;
use App\Modules\Authorization\Presentation\Requests\UpdateRoleRequest;
use App\Shared\Domain\Exception\DomainException;
use App\Shared\SessionManager\AuthSession;
use App\Shared\Web\Responses\JsonResponse;

final class UpdateRoleController extends AuthorizationController
{
    public function __construct(
        private UpdateRoleUseCase $updateRoleUseCase,
        private AuthSession $authSession
    ) {}

    public function update(UpdateRoleRequest $request): JsonResponse
    {
        try {
            $this->updateRoleUseCase->execute($request, $this->authSession->authUser()->user_id);

            return new JsonResponse([]);
        } catch (DomainException $e) {
            return new JsonResponse([
                'errors' => [$e->getMessage()],
            ], 422);
        }
    }
}
