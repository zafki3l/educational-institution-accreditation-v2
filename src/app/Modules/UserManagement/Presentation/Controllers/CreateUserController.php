<?php

namespace App\Modules\UserManagement\Presentation\Controllers;

use App\Modules\Authorization\Application\Readers\RoleReaderInterface;
use App\Modules\UserManagement\Application\UseCases\CreateUserUseCase;
use App\Modules\UserManagement\Presentation\Requests\CreateUserRequest;
use App\Shared\Exception\DomainException;
use App\Shared\Response\JsonResponse;
use App\Shared\Response\ViewResponse;
use App\Shared\SessionManager\AuthSession;

final class CreateUserController extends UserController
{
    public function __construct(
        private RoleReaderInterface $roleReader,
        private CreateUserUseCase $createUserUseCase,
        private AuthSession $authSession
    ) {}

    public function create(): ViewResponse
    {
        $roles = $this->roleReader->all();

        return new ViewResponse(
            self::MODULE_NAME,
            'create/main',
            'main.layouts',
            [
                'title' => 'Thêm người dùng | ' . SYSTEM_NAME,
                'roles' => $roles
            ]
        );
    }

    public function store(CreateUserRequest $request): JsonResponse
    {
        try {
            $this->createUserUseCase->execute($request, $this->authSession->authUser()->user_id);

            return new JsonResponse([], 200);
        } catch (DomainException $e) {
            return new JsonResponse([
                'errors' => [$e->getMessage()]
            ], 422);
        }
    }
}
