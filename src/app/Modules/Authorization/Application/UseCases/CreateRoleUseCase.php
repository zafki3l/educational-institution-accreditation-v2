<?php

namespace App\Modules\Authorization\Application\UseCases;

use App\Modules\Authorization\Application\Requests\CreateRoleRequestInterface;
use App\Modules\Authorization\Domain\Entities\Role;
use App\Modules\Authorization\Domain\Events\RoleCreated;
use App\Modules\Authorization\Domain\Repositories\RoleRepositoryInterface;
use App\Shared\Contracts\Events\EventDispatcherInterface;

final class CreateRoleUseCase
{
    public function __construct(
        private RoleRepositoryInterface $repository,
        private EventDispatcherInterface $eventDispatcher
    ) {}

    public function execute(CreateRoleRequestInterface $request, string $actor_id): void
    {
        $role = Role::create($request->getName());

        $this->repository->create($role);

        $this->eventDispatcher->dispatch(new RoleCreated($role->getName(), $actor_id));
    }
}