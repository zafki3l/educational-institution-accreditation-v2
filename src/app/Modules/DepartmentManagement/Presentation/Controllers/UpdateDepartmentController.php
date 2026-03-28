<?php

namespace App\Modules\DepartmentManagement\Presentation\Controllers;

use App\Modules\DepartmentManagement\Application\UseCases\UpdateDepartmentUseCase;
use App\Modules\DepartmentManagement\Presentation\Controllers\DepartmentController;
use App\Modules\DepartmentManagement\Presentation\Requests\UpdateDepartmentRequest;
use App\Shared\Domain\Exception\DomainException;
use App\Shared\Response\JsonResponse;
use App\Shared\SessionManager\AuthSession;

final class UpdateDepartmentController extends DepartmentController
{
    public function __construct(
        private UpdateDepartmentUseCase $updateDepartmentUseCase,
        private AuthSession $authSession
    ) {}

    public function update(string $id, UpdateDepartmentRequest $request): JsonResponse
    {
        try {
            $this->updateDepartmentUseCase->execute($id, $request, $this->authSession->authUser()->user_id);

            return new JsonResponse([], 200);
        } catch (DomainException $e) {
            return new JsonResponse([
                'errors' => [$e->getMessage()]
            ], 422);
        }
    }
}
