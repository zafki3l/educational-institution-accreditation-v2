<?php

namespace App\Modules\DepartmentManagement\Presentation\Controllers;

use App\Modules\DepartmentManagement\Application\UseCases\CreateDepartmentUseCase;
use App\Modules\DepartmentManagement\Presentation\Controllers\DepartmentController;
use App\Modules\DepartmentManagement\Presentation\Requests\CreateDepartmentRequest;
use App\Shared\Domain\Exception\DomainException;
use App\Shared\Security\Session\AuthSession;
use App\Shared\Web\Responses\JsonResponse;

final class CreateDepartmentController extends DepartmentController
{
    public function __construct(
        private CreateDepartmentUseCase $createDepartmentUseCase,
        private AuthSession $authSession
    ) {}

    public function store(CreateDepartmentRequest $request): JsonResponse
    {
        try {
            $this->createDepartmentUseCase->execute($request, $this->authSession->authUser()->user_id);

            return new JsonResponse([], 200);
        } catch (DomainException $e) {
            return new JsonResponse([
                'errors' => [$e->getMessage()]
            ], 422);
        }
    }
}