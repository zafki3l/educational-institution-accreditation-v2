<?php

namespace Tests\Unit\Modules\DepartmentManagement\Application\UseCases;

use App\Modules\DepartmentManagement\Application\Requests\CreateDepartmentRequestInterface;
use App\Modules\DepartmentManagement\Application\UseCases\CreateDepartmentUseCase;
use App\Modules\DepartmentManagement\Domain\Entities\Department;
use App\Modules\DepartmentManagement\Domain\Exception\EmptyDepartmentIdException;
use App\Modules\DepartmentManagement\Domain\Repositories\DepartmentRepositoryInterface;
use App\Shared\Contracts\Events\EventDispatcherInterface;
use App\Shared\Contracts\UnitOfWork\UnitOfWorkInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TraitHelper\DebugHelper;

class CreateDepartmentUseCaseTest extends TestCase
{
    use DebugHelper;

    private DepartmentRepositoryInterface&MockObject $repository;
    private EventDispatcherInterface&MockObject $eventDispatcher;
    private UnitOfWorkInterface&MockObject $unitOfWork;
    private CreateDepartmentUseCase $useCase;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(DepartmentRepositoryInterface::class);
        $this->eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->unitOfWork = $this->createMock(UnitOfWorkInterface::class);

        $this->unitOfWork->method('execute')
            ->willReturnCallback(fn(callable $work) => $work());

        $this->useCase = new CreateDepartmentUseCase(
            $this->repository, 
            $this->eventDispatcher,
            $this->unitOfWork
        );
    }

    public function testExecuteSuccess(): void
    {
        $actorId = 'admin-uuid';
        $deptId = 'DEPT-001';
        $deptName = 'Phòng Kế Toán';
        
        $request = $this->createMock(CreateDepartmentRequestInterface::class);
        $request->method('getId')->willReturn($deptId);
        $request->method('getName')->willReturn($deptName);

        $this->debug('INPUT', ['id' => $deptId, 'name' => $deptName]);

        $this->repository->expects($this->once())
            ->method('create')
            ->with($this->callback(function (Department $dept) use ($deptId, $deptName) {
                return $dept->getId() === $deptId && $dept->getName() === $deptName;
            }));

        $this->eventDispatcher->expects($this->once())
            ->method('dispatch');

        $this->useCase->execute($request, $actorId);
    }

    public function testExecuteThrowsExceptionWhenDataIsInvalid(): void
    {
        $request = $this->createMock(CreateDepartmentRequestInterface::class);
        $request->method('getId')->willReturn('');

        $this->debug('TEST CASE: Expecting EmptyDepartmentIdException', []);

        $this->repository->expects($this->never())->method('create');
        $this->eventDispatcher->expects($this->never())->method('dispatch');

        $this->expectException(EmptyDepartmentIdException::class);

        $this->useCase->execute($request, 'admin-uuid');
    }

    public function testExecuteDoesNotDispatchEventWhenRepositoryFails(): void
    {
        $request = $this->createMock(CreateDepartmentRequestInterface::class);
        $request->method('getId')->willReturn('DEPT-002');
        $request->method('getName')->willReturn('Phòng Nhân Sự');

        $this->repository->method('create')
            ->willThrowException(new \Exception("Database error"));

        $this->eventDispatcher->expects($this->never())->method('dispatch');

        $this->expectException(\Exception::class);

        $this->useCase->execute($request, 'admin-uuid');
    }
}