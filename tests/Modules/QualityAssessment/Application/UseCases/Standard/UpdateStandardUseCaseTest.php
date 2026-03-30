<?php

namespace Tests\Unit\Modules\QualityAssessment\Application\UseCases\Standard;

use App\Modules\QualityAssessment\Application\Requests\Standard\UpdateStandardRequestInterface;
use App\Modules\QualityAssessment\Application\UseCases\Standard\UpdateStandardUseCase;
use App\Modules\QualityAssessment\Domain\Entities\Standard;
use App\Modules\QualityAssessment\Domain\Repositories\StandardRepositoryInterface;
use App\Shared\Contracts\Events\EventDispatcherInterface;
use App\Shared\Contracts\UnitOfWork\UnitOfWorkInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TraitHelper\DebugHelper;

final class UpdateStandardUseCaseTest extends TestCase
{
    use DebugHelper;

    private StandardRepositoryInterface&MockObject $repository;
    private EventDispatcherInterface&MockObject $eventDispatcher;
    private UnitOfWorkInterface&MockObject $unitOfWork;
    private UpdateStandardUseCase $useCase;

    private const VALID_ACTOR_ID = 'f47ac10b-58cc-4372-a567-0e02b2c3d479';

    protected function setUp(): void
    {
        $this->repository = $this->createMock(StandardRepositoryInterface::class);
        $this->eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->unitOfWork = $this->createMock(UnitOfWorkInterface::class);

        $this->unitOfWork->method('execute')->willReturnCallback(fn($callback) => $callback());

        $this->useCase = new UpdateStandardUseCase(
            $this->repository,
            $this->eventDispatcher,
            $this->unitOfWork
        );
    }

    public function testUpdateSuccessfullyWhenDataChanged(): void
    {
        $id = '1';
        $request = $this->createMock(UpdateStandardRequestInterface::class);
        $request->method('getId')->willReturn($id);
        $request->method('getName')->willReturn('Tên mới');
        $request->method('getDepartmentId')->willReturn('DEPT-NEW');

        $standard = $this->createMock(Standard::class);
        $standard->method('getId')->willReturn($id);
        
        $standard->method('hasChanges')->willReturn(true);
        $standard->method('getChanges')->willReturn(['name' => ['old' => 'Cũ', 'new' => 'Mới']]);

        $this->repository->expects($this->once())
            ->method('findOrFail')
            ->with($id)
            ->willReturn($standard);

        $standard->expects($this->once())->method('update')->with('Tên mới', 'DEPT-NEW');
        $this->repository->expects($this->once())->method('update')->with($standard);
        $this->eventDispatcher->expects($this->once())->method('dispatch');

        $this->useCase->execute($request, self::VALID_ACTOR_ID);

        $this->debug('UPDATE SUCCESS', ['id' => $id]);
    }

    public function testUpdateDoesNothingWhenNoDataChanged(): void
    {
        $id = '1';
        $request = $this->createMock(UpdateStandardRequestInterface::class);
        $request->method('getId')->willReturn($id);
        $request->method('getName')->willReturn('Tên cũ');
        $request->method('getDepartmentId')->willReturn('DEPT-OLD');

        $standard = $this->createMock(Standard::class);
        
        $standard->method('hasChanges')->willReturn(false);

        $this->repository->method('findOrFail')->willReturn($standard);

        $standard->expects($this->once())->method('update');
        $this->unitOfWork->expects($this->never())->method('execute');
        $this->repository->expects($this->never())->method('update');
        $this->eventDispatcher->expects($this->never())->method('dispatch');

        $this->useCase->execute($request, self::VALID_ACTOR_ID);
        
        $this->debug('UPDATE SKIPPED', ['reason' => 'No changes detected']);
    }

    public function testUpdateThrowsExceptionWhenNotFound(): void
    {
        $request = $this->createMock(UpdateStandardRequestInterface::class);
        $request->method('getId')->willReturn('999');

        $this->repository->method('findOrFail')
            ->willThrowException(new \Exception("Standard not found"));

        $this->expectException(\Exception::class);
        
        $this->repository->expects($this->never())->method('update');

        $this->useCase->execute($request, self::VALID_ACTOR_ID);
    }
}