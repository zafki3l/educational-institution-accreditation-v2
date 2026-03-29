<?php

namespace App\Modules\DepartmentManagement\Application\UseCases;

use App\Modules\DepartmentManagement\Application\Requests\UpdateDepartmentRequestInterface;
use App\Modules\DepartmentManagement\Domain\Events\DepartmentUpdated;
use App\Modules\DepartmentManagement\Domain\Repositories\DepartmentRepositoryInterface;
use App\Modules\DepartmentManagement\Domain\Services\DepartmentExistsCheckerInterface;
use App\Shared\Contracts\Events\EventDispatcherInterface;
use App\Shared\Contracts\UnitOfWork\UnitOfWorkInterface;

final class UpdateDepartmentUseCase 
{
    public function __construct(
        private DepartmentRepositoryInterface $repository,
        private EventDispatcherInterface $eventDispatcher,
        private UnitOfWorkInterface $unitOfWork,
        private DepartmentExistsCheckerInterface $departmentExistsChecker
    ) {}

    public function execute(string $id, UpdateDepartmentRequestInterface $request, string $actor_id): void
    {
        $department = $this->repository->findOrFail($id);

        $this->departmentExistsChecker->check($department);

        $department->update($request->getName());

        if (empty($department->getChanges())) {
            return;
        }

        $this->unitOfWork->execute(function () use ($department, $actor_id) {
            $this->repository->update($department);

            $this->eventDispatcher->dispatch(new DepartmentUpdated(
                $department->getId(), 
                $department->getChanges(),
                $actor_id
            ));
        });
    }
}
