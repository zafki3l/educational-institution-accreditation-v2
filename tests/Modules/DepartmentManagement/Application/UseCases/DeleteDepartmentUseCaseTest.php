<?php

namespace Tests\Unit\Modules\DepartmentManagement\Application\UseCases;

use App\Modules\DepartmentManagement\Application\UseCases\DeleteDepartmentUseCase;
use App\Modules\DepartmentManagement\Domain\Entities\Department;
use App\Modules\DepartmentManagement\Domain\Repositories\DepartmentRepositoryInterface;
use App\Modules\DepartmentManagement\Domain\Services\DepartmentExistsCheckerInterface;
use App\Shared\Contracts\Events\EventDispatcherInterface;
use App\Shared\Contracts\UnitOfWork\UnitOfWorkInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TraitHelper\DebugHelper;

class DeleteDepartmentUseCaseTest extends TestCase
{
    use DebugHelper;

    private DepartmentRepositoryInterface&MockObject $repository;
    private EventDispatcherInterface&MockObject $eventDispatcher;
    private UnitOfWorkInterface&MockObject $unitOfWork;
    private DepartmentExistsCheckerInterface&MockObject $checker;
    private DeleteDepartmentUseCase $useCase;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(DepartmentRepositoryInterface::class);
        $this->eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->unitOfWork = $this->createMock(UnitOfWorkInterface::class);
        $this->checker = $this->createMock(DepartmentExistsCheckerInterface::class);

        $this->unitOfWork->method('execute')
            ->willReturnCallback(fn(callable $work) => $work());

        $this->useCase = new DeleteDepartmentUseCase(
            $this->repository, 
            $this->eventDispatcher,
            $this->unitOfWork,
            $this->checker
        );
    }

    public function testExecuteSuccess(): void
    {
        $deptId = 'DEPT-999';
        $actorId = 'admin-001';
        $deptName = 'Phòng Kỹ Thuật';

        $department = $this->createMock(Department::class);
        $department->method('getId')->willReturn($deptId);
        $department->method('getName')->willReturn($deptName);

        $this->repository->expects($this->once())
            ->method('findOrFail')
            ->with($deptId)
            ->willReturn($department);

        $this->checker->expects($this->once())
            ->method('check')
            ->with($department);

        $this->repository->expects($this->once())
            ->method('delete')
            ->with($department);

        $this->eventDispatcher->expects($this->once())
            ->method('dispatch');

        $this->useCase->execute($deptId, $actorId);
        
        $this->debug('SUCCESS', ['id' => $deptId, 'status' => 'Deleted']);
    }

    public function testExecuteThrowsExceptionWhenNotFound(): void
    {
        $invalidId = 'NON-EXIST';
        
        $this->repository->method('findOrFail')->willReturn(null);

        $this->checker->method('check')
            ->willThrowException(new \Exception("Department not found"));

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Department not found");

        $this->repository->expects($this->never())->method('delete');
        $this->eventDispatcher->expects($this->never())->method('dispatch');

        $this->useCase->execute($invalidId, 'admin-001');
    }

    public function testExecuteDoesNotDispatchEventWhenDeletionFails(): void
    {
        $deptId = 'DEPT-555';
        $department = $this->createMock(Department::class);

        $this->repository->method('findOrFail')->willReturn($department);
        
        $this->checker->method('check');

        $this->repository->method('delete')
            ->willThrowException(new \Exception("DB Delete Error"));

        $this->eventDispatcher->expects($this->never())->method('dispatch');

        $this->expectException(\Exception::class);

        $this->useCase->execute($deptId, 'admin-001');
    }
}