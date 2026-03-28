<?php

namespace App\Modules\UserManagement\Presentation\Controllers;

use App\Modules\UserManagement\Application\Readers\UserReaderInterface;
use App\Modules\UserManagement\Application\UseCases\UpdateUserUseCase;
use App\Modules\UserManagement\Presentation\Controllers\UserController;
use App\Modules\UserManagement\Presentation\Requests\UpdateUserRequest;
use App\Modules\UserManagement\Presentation\ViewModel\EditUserViewModel;
use App\Shared\Domain\Exception\DomainException;
use App\Shared\Response\JsonResponse;
use App\Shared\SessionManager\AuthSession;

final class UpdateUserController extends UserController
{
    public function __construct(
        private UserReaderInterface $userReader,
        private UpdateUserUseCase $updateUserUseCase,
        private AuthSession $authSession
    ) {}

    public function edit(string $id): JsonResponse
    {
        $user = $this->userReader->findById($id);

        $editUserViewModel = new EditUserViewModel(
            $user->id,
            $user->first_name,
            $user->last_name,
            $user->email,
            $user->role_id,
            $user->department_id ?? null
        );

        return new JsonResponse($editUserViewModel->toArray());
    }

    public function update(UpdateUserRequest $request)
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