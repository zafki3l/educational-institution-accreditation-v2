<?php

namespace App\Modules\DepartmentManagement\Application\UseCases;

use App\Modules\DepartmentManagement\Application\Requests\CreateDepartmentRequestInterface;
use App\Modules\DepartmentManagement\Domain\Entities\Department;
use App\Modules\DepartmentManagement\Domain\Events\DepartmentCreated;
use App\Modules\DepartmentManagement\Domain\Repositories\DepartmentRepositoryInterface;
use App\Shared\Contracts\Events\EventDispatcherInterface;

final class CreateDepartmentUseCase 
{
    public function __construct(
        private DepartmentRepositoryInterface $repository,
        private EventDispatcherInterface $eventDispatcher
    ) {}

    public function execute(CreateDepartmentRequestInterface $request, string $actor_id): void
    {
        $department = Department::create(
            $request->getId(),
            $request->getName()
        );

        $this->repository->create($department);

        $this->eventDispatcher->dispatch(new DepartmentCreated($department->getId(), $department->getName(), $actor_id));
    }
}