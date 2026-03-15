<?php

namespace App\Modules\Authorization\Application\Role\UseCases;

use App\Modules\Authorization\Application\Role\Requests\UpdateRoleRequestInterface;
use App\Modules\Authorization\Domain\Repositories\RoleRepositoryInterface;
use App\Shared\Logging\LoggerInterface;

final class UpdateRoleUseCase
{
    public function __construct(
        private RoleRepositoryInterface $repository,
        private LoggerInterface $logger
    ) {}

    public function execute(UpdateRoleRequestInterface $request, string $actor_id): void
    {
        $role = $this->repository->findOrFail($request->getId());

        $role->rename($request->getName());

        $this->repository->update($role);

        $this->writeLog($request, $actor_id);
    }

    private function writeLog(UpdateRoleRequestInterface $request, string $actor_id): void
    {
        $this->logger->write(
            'info',
            'update',
            "Người dùng {$actor_id} đã cập nhật vai trò {$request->getId()}",
            $actor_id,
            ['id' => $request->getId(), 'new_name' => $request->getName()]
        );
    }
}
