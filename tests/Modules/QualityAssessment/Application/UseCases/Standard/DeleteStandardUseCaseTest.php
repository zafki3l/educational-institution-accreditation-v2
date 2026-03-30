<?php

namespace Tests\Unit\Modules\QualityAssessment\Application\UseCases\Standard;

use App\Modules\QualityAssessment\Application\UseCases\Standard\DeleteStandardUseCase;
use App\Modules\QualityAssessment\Domain\Entities\Standard;
use App\Modules\QualityAssessment\Domain\Repositories\StandardRepositoryInterface;
use App\Shared\Contracts\Events\EventDispatcherInterface;
use App\Shared\Contracts\UnitOfWork\UnitOfWorkInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TraitHelper\DebugHelper;

final class DeleteStandardUseCaseTest extends TestCase
{
    use DebugHelper;

    private StandardRepositoryInterface&MockObject $repository;
    private EventDispatcherInterface&MockObject $eventDispatcher;
    private UnitOfWorkInterface&MockObject $unitOfWork;
    private DeleteStandardUseCase $useCase;

    private const VALID_STANDARD_ID = '1';
    private const VALID_ACTOR_ID = 'f47ac10b-58cc-4372-a567-0e02b2c3d479';

    protected function setUp(): void
    {
        $this->repository = $this->createMock(StandardRepositoryInterface::class);
        $this->eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->unitOfWork = $this->createMock(UnitOfWorkInterface::class);

        $this->unitOfWork->method('execute')->willReturnCallback(function ($callback) {
            return $callback();
        });

        $this->useCase = new DeleteStandardUseCase(
            $this->repository,
            $this->eventDispatcher,
            $this->unitOfWork
        );
    }

    public function testDeleteSuccessfully(): void
    {
        $id = self::VALID_STANDARD_ID;
        $actorId = self::VALID_ACTOR_ID; 
        
        $standard = $this->createMock(Standard::class);
        $standard->method('getId')->willReturn($id);

        $this->repository->expects($this->once())
            ->method('findOrFail')
            ->with($id)
            ->willReturn($standard);

        $this->repository->expects($this->once())
            ->method('delete')
            ->with($standard);

        $this->eventDispatcher->expects($this->once())->method('dispatch');

        $this->useCase->execute($id, $actorId);

        $this->debug('DELETE SUCCESS', ['id' => $id, 'actor_id' => $actorId]);
    }

    public function testDeleteThrowsExceptionWhenNotFound(): void
    {
        $invalidId = '999';
        
        $this->repository->method('findOrFail')
            ->with($invalidId)
            ->willThrowException(new \Exception("Standard not found"));

        $this->expectException(\Exception::class);

        $this->repository->expects($this->never())->method('delete');
        $this->eventDispatcher->expects($this->never())->method('dispatch');

        $this->useCase->execute($invalidId, self::VALID_ACTOR_ID);
    }

    public function testDeleteDoesNothingWhenStandardIsNull(): void
    {
        $id = '123';
        $this->repository->method('findOrFail')->willReturn(null);

        $this->unitOfWork->expects($this->never())->method('execute');
        $this->repository->expects($this->never())->method('delete');

        $this->useCase->execute($id, 'actor-id');
    }
}