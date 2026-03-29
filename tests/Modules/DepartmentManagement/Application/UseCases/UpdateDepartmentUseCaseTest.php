<?php

namespace Tests\Unit\Modules\DepartmentManagement\Application\UseCases;

use App\Modules\DepartmentManagement\Application\Requests\UpdateDepartmentRequestInterface;
use App\Modules\DepartmentManagement\Application\UseCases\UpdateDepartmentUseCase;
use App\Modules\DepartmentManagement\Domain\Entities\Department;
use App\Modules\DepartmentManagement\Domain\Exception\DepartmentNotFoundException;
use App\Modules\DepartmentManagement\Domain\Repositories\DepartmentRepositoryInterface;
use App\Modules\DepartmentManagement\Domain\Services\DepartmentExistsCheckerInterface;
use App\Shared\Contracts\Events\EventDispatcherInterface;
use App\Shared\Contracts\UnitOfWork\UnitOfWorkInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TraitHelper\DebugHelper;

final class UpdateDepartmentUseCaseTest extends TestCase
{
    use DebugHelper;

    private DepartmentRepositoryInterface&MockObject $repository;
    private EventDispatcherInterface&MockObject $eventDispatcher;
    private UnitOfWorkInterface&MockObject $unitOfWork;
    private DepartmentExistsCheckerInterface&MockObject $checker; 
    private UpdateDepartmentUseCase $useCase;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(DepartmentRepositoryInterface::class);
        $this->eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->unitOfWork = $this->createMock(UnitOfWorkInterface::class);
        $this->checker = $this->createMock(DepartmentExistsCheckerInterface::class);

        $this->unitOfWork->method('execute')
            ->willReturnCallback(fn(callable $work) => $work());

        $this->useCase = new UpdateDepartmentUseCase(
            $this->repository,
            $this->eventDispatcher,
            $this->unitOfWork,
            $this->checker
        );
    }

    public function testExecuteSuccessfully(): void
    {
        $departmentId = 'DEPT-001';
        $actorId = 'admin-1';
        $newName = 'Phòng Đào Tạo Mới';

        $request = $this->createMock(UpdateDepartmentRequestInterface::class);
        $request->method('getName')->willReturn($newName);

        $department = Department::create($departmentId, 'Tên Cũ'); 

        $this->repository->method('findOrFail')
            ->with($departmentId)
            ->willReturn($department);

        $this->checker->expects($this->once())
            ->method('check')
            ->with($department);

        $this->repository->expects($this->once())
            ->method('update')
            ->with($this->callback(fn(Department $dept) => $dept->getName() === $newName));

        $this->eventDispatcher->expects($this->once())->method('dispatch');

        $this->useCase->execute($departmentId, $request, $actorId);
        
        $this->assertSame($newName, $department->getName());
    }

    public function testExecuteThrowsExceptionWhenNotFound(): void
    {
        $departmentId = 'UNKNOWN';
        $request = $this->createMock(UpdateDepartmentRequestInterface::class);

        $this->repository->method('findOrFail')->willReturn(null);

        $this->checker->method('check')
            ->willThrowException(new DepartmentNotFoundException());

        $this->expectException(DepartmentNotFoundException::class);

        $this->useCase->execute($departmentId, $request, 'actor-1');
    }

    public function testExecuteDoesNothingWhenNameIsUnchanged(): void
    {
        $id = 'DEPT-01';
        $name = 'Same Name';
        $department = Department::create($id, $name);

        $request = $this->createMock(UpdateDepartmentRequestInterface::class);
        $request->method('getName')->willReturn($name);

        $this->repository->method('findOrFail')->willReturn($department);

        $this->unitOfWork->expects($this->never())->method('execute');
        $this->repository->expects($this->never())->method('update');

        $this->useCase->execute($id, $request, 'admin-1');
    }

    public function testExecuteDoesNotDispatchEventWhenUpdateFails(): void
    {
        $departmentId = 'DEPT-001';
        $request = $this->createMock(UpdateDepartmentRequestInterface::class);
        $request->method('getName')->willReturn('New Name');
        
        $department = Department::create($departmentId, 'Old Name');
        $this->repository->method('findOrFail')->willReturn($department);

        $this->repository->method('update')
            ->willThrowException(new \Exception("DB Update Error"));

        $this->eventDispatcher->expects($this->never())->method('dispatch');

        $this->expectException(\Exception::class);

        $this->useCase->execute($departmentId, $request, 'actor-1');
    }
}