<?php

namespace Tests\Unit\Modules\QualityAssessment\Application\UseCases\Standard;

use App\Modules\QualityAssessment\Application\Requests\Standard\CreateStandardRequestInterface;
use App\Modules\QualityAssessment\Application\UseCases\Standard\CreateStandardUseCase;
use App\Modules\QualityAssessment\Domain\Entities\Standard;
use App\Modules\QualityAssessment\Domain\Repositories\StandardRepositoryInterface;
use App\Modules\QualityAssessment\Domain\Exception\Standard\StandardEmptyIdException;
use App\Modules\QualityAssessment\Domain\Exception\Standard\StandardEmptyNameException;
use App\Modules\QualityAssessment\Domain\Exception\Standard\StandardEmptyDepartmentIdException;
use App\Shared\Contracts\Events\EventDispatcherInterface;
use App\Shared\Contracts\UnitOfWork\UnitOfWorkInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\TraitHelper\DebugHelper;

final class CreateStandardUseCaseTest extends TestCase
{
    use DebugHelper;

    private StandardRepositoryInterface&MockObject $repository;
    private EventDispatcherInterface&MockObject $eventDispatcher;
    private UnitOfWorkInterface&MockObject $unitOfWork;
    private CreateStandardUseCase $useCase;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(StandardRepositoryInterface::class);
        $this->eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->unitOfWork = $this->createMock(UnitOfWorkInterface::class);

        $this->unitOfWork->method('execute')->willReturnCallback(function ($callback) {
            return $callback();
        });

        $this->useCase = new CreateStandardUseCase(
            $this->repository, 
            $this->eventDispatcher, 
            $this->unitOfWork
        );
    }

    public function testExecuteSuccessfully(): void
    {
        $actorId = 'user-admin';
        $request = $this->createMock(CreateStandardRequestInterface::class);
        $request->method('getId')->willReturn('1');
        $request->method('getName')->willReturn('Tiêu chuẩn 1');
        $request->method('getDepartmentId')->willReturn('DEPT-01');

        $this->repository->expects($this->once())
            ->method('create')
            ->with($this->isInstanceOf(Standard::class));

        $this->eventDispatcher->expects($this->once())
            ->method('dispatch');

        $this->useCase->execute($request, $actorId);
        
        $this->debug('CREATE STANDARD SUCCESS', ['id' => '1']);
    }

    #[DataProvider('invalidRequestProvider')]
    public function testExecuteThrowsExceptionForInvalidFields(
        string $id, 
        string $name, 
        string $deptId, 
        string $expectedException
    ): void {
        $request = $this->createMock(CreateStandardRequestInterface::class);
        $request->method('getId')->willReturn($id);
        $request->method('getName')->willReturn($name);
        $request->method('getDepartmentId')->willReturn($deptId);

        $this->expectException($expectedException);

        $this->repository->expects($this->never())->method('create');
        $this->eventDispatcher->expects($this->never())->method('dispatch');

        $this->useCase->execute($request, 'actor-123');
    }

    public static function invalidRequestProvider(): array
    {
        return [
            'empty_id' => ['', 'Name', 'Dept', StandardEmptyIdException::class],
            'empty_name' => ['1', '', 'Dept', StandardEmptyNameException::class],
            'empty_dept' => ['1', 'Name', '', StandardEmptyDepartmentIdException::class],
        ];
    }
}