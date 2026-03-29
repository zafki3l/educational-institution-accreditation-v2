<?php

namespace App\Modules\DepartmentManagement\Application\UseCases;

use App\Modules\DepartmentManagement\Domain\Events\DepartmentDeleted;
use App\Modules\DepartmentManagement\Domain\Repositories\DepartmentRepositoryInterface;
use App\Modules\DepartmentManagement\Domain\Services\DepartmentExistsCheckerInterface;
use App\Shared\Contracts\Events\EventDispatcherInterface;
use App\Shared\Contracts\UnitOfWork\UnitOfWorkInterface;

final class DeleteDepartmentUseCase
{
    public function __construct(
        private DepartmentRepositoryInterface $repository,
        private EventDispatcherInterface $eventDispatcher,
        private UnitOfWorkInterface $unitOfWork,
        private DepartmentExistsCheckerInterface $departmentExistsChecker
    ) {}

    public function execute(string $id, string $actor_id): void
    {
        $department = $this->repository->findOrFail($id);

        $this->departmentExistsChecker->check($department);

        $this->unitOfWork->execute(function () use ($department, $actor_id) {
            $this->repository->delete($department);

            $this->eventDispatcher->dispatch(new DepartmentDeleted(
                $department->getId(), 
                $department->getName(), 
                $actor_id
            ));
        });
    }
}