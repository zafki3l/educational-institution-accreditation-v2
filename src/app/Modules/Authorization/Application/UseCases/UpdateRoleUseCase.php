<?php

namespace App\Modules\Authorization\Application\UseCases;

use App\Modules\Authorization\Application\Requests\UpdateRoleRequestInterface;
use App\Modules\Authorization\Domain\Events\RoleUpdated;
use App\Modules\Authorization\Domain\Repositories\RoleRepositoryInterface;
use App\Shared\Contracts\Events\EventDispatcherInterface;

final class UpdateRoleUseCase
{
    public function __construct(
        private RoleRepositoryInterface $repository,
        private EventDispatcherInterface $eventDispatcher
    ) {}

    public function execute(UpdateRoleRequestInterface $request, string $actor_id): void
    {
        $role = $this->repository->findOrFail($request->getId());

        $role->rename($request->getName());

        $this->repository->update($role);

        $this->eventDispatcher->dispatch(new RoleUpdated(
            $role->getId(), 
            $role->getName(), 
            $actor_id
        ));
    }
}
