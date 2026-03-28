<?php

namespace App\Modules\DepartmentManagement\Application\UseCases;

use App\Modules\DepartmentManagement\Application\Requests\UpdateDepartmentRequestInterface;
use App\Modules\DepartmentManagement\Domain\Events\DepartmentUpdated;
use App\Modules\DepartmentManagement\Domain\Exception\DepartmentNotFoundException;
use App\Modules\DepartmentManagement\Domain\Repositories\DepartmentRepositoryInterface;
use App\Shared\Contracts\Events\EventDispatcherInterface;

final class UpdateDepartmentUseCase 
{
    public function __construct(
        private DepartmentRepositoryInterface $repository,
        private EventDispatcherInterface $eventDispatcher
    ) {}

    public function execute(string $id, UpdateDepartmentRequestInterface $request, string $actor_id): void
    {
        $department = $this->repository->findOrFail($id);

        if (!$department) {
            throw new DepartmentNotFoundException();
        }

        $old_name = $department->getName();

        $department->update(
            $request->getName()
        );

        $this->repository->update($department);

        $this->eventDispatcher->dispatch(new DepartmentUpdated(
            $department->getId(), 
            $old_name, 
            $department->getName(), 
            $actor_id
        ));
    }
}
