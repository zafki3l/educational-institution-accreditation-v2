<?php

namespace App\Modules\Authorization\Application\UseCases;

use App\Modules\Authorization\Domain\Events\RoleDeleted;
use App\Modules\Authorization\Domain\Repositories\RoleRepositoryInterface;
use App\Shared\Contracts\Events\EventDispatcherInterface;

final class DeleteRoleUseCase
{
    public function __construct(
        private RoleRepositoryInterface $repository,
        private EventDispatcherInterface $eventDispatcher
    ) {}

    public function execute(int $id, string $actor_id)
    {
        $role = $this->repository->findOrFail($id);

        $this->repository->delete($role);

        $this->eventDispatcher->dispatch(new RoleDeleted(
            $role->getId(), 
            $role->getName(), 
            $actor_id
        ));
    }
}