<?php

namespace App\Modules\DepartmentManagement\Application\UseCases;

use App\Modules\DepartmentManagement\Domain\Events\DepartmentDeleted;
use App\Modules\DepartmentManagement\Domain\Repositories\DepartmentRepositoryInterface;
use App\Shared\Contracts\Events\EventDispatcherInterface;

final class DeleteDepartmentUseCase
{
    public function __construct(
        private DepartmentRepositoryInterface $repository,
        private EventDispatcherInterface $eventDispatcher
    ) {}

    public function execute(string $id, string $actor_id): void
    {
        $department = $this->repository->findOrFail($id);

        $this->repository->delete($department);

        $this->eventDispatcher->dispatch(new DepartmentDeleted($department->getId(), $department->getName(), $actor_id));
    }
}