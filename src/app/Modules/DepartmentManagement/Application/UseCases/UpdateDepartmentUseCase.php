<?php

namespace App\Modules\DepartmentManagement\Application\UseCases;

use App\Modules\DepartmentManagement\Application\Requests\UpdateDepartmentRequestInterface;
use App\Modules\DepartmentManagement\Domain\Entities\Department;
use App\Modules\DepartmentManagement\Domain\Repositories\DepartmentRepositoryInterface;
use App\Shared\Exception\DomainException;
use App\Shared\Logging\LoggerInterface;

final class UpdateDepartmentUseCase 
{
    public function __construct(
        private DepartmentRepositoryInterface $repository,
        private LoggerInterface $logger
    ) {}

    public function execute(string $id, UpdateDepartmentRequestInterface $request, string $actor_id): void
    {
        try {
            $department = $this->repository->findOrFail($id);
        } catch (\Exception $e) {
            throw new DomainException("Phòng ban không tồn tại.");
        }

        if ($this->repository->existsByNameExcludingId($request->getName(), $id)) {
            throw new DomainException("Tên phòng ban đã tồn tại.");
        }

        $department->update(
            $request->getName()
        );

        $this->repository->update($department);

        $this->writeLog($request, $actor_id);
    }

    private function writeLog(UpdateDepartmentRequestInterface $request, string $actor_id): void
    {
        $this->logger->write(
            'info',
            'update', 
            "Người dùng {$actor_id} đã cập nhật thông tin phòng ban", 
            $actor_id, 
            ['name' => $request->getName()]
        );
    }
}
