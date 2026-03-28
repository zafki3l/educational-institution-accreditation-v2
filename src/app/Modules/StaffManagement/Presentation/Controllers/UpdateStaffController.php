<?php

namespace App\Modules\StaffManagement\Presentation\Controllers;

use App\Modules\StaffManagement\Presentation\Requests\UpdateStaffRequest;
use App\Modules\UserManagement\Application\Readers\UserReaderInterface;
use App\Modules\UserManagement\Application\UseCases\UpdateUserUseCase;
use App\Shared\Domain\Exception\DomainException;
use App\Shared\Response\JsonResponse;
use App\Shared\SessionManager\AuthSession;

final class UpdateStaffController extends StaffController
{
    public function __construct(
        private UserReaderInterface $userReader,
        private UpdateUserUseCase $updateUserUseCase,
        private AuthSession $authSession
    ) {}

    public function edit(string $id): JsonResponse
    {
        $staff = $this->userReader->findById($id);

        return new JsonResponse([
            'id' => $staff->id,
            'first_name' => $staff->first_name,
            'last_name' => $staff->last_name,
            'email' => $staff->email ?? '',
            'department_id' => $staff->department_id ?? ''
        ]);
    }

    public function update(UpdateStaffRequest $request): JsonResponse
    {
        try {
            $this->updateUserUseCase->execute($request, $this->authSession->authUser()->user_id);

            return new JsonResponse([]);
        } catch (DomainException $e) {
            return new JsonResponse([
                'errors' => [$e->getMessage()],
            ], 422);
        }
    }
}
