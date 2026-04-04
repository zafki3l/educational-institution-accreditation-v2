<?php

namespace Tests\Unit\Modules\QualityAssessment\Application\UseCases\Milestone;

use App\Modules\QualityAssessment\Application\UseCases\Milestone\DeleteMilestoneUseCase;
use App\Modules\QualityAssessment\Domain\Entities\Milestone;
use App\Modules\QualityAssessment\Domain\Repositories\MilestoneRepositoryInterface;
use App\Modules\QualityAssessment\Domain\ValueObjects\Milestone\MilestoneCode;
use App\Shared\Contracts\Events\EventDispatcherInterface;
use App\Shared\Contracts\UnitOfWork\UnitOfWorkInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TraitHelper\DebugHelper;

final class DeleteMilestoneUseCaseTest extends TestCase
{
    use DebugHelper;

    private MilestoneRepositoryInterface&MockObject $repository;
    private EventDispatcherInterface&MockObject $eventDispatcher;
    private UnitOfWorkInterface&MockObject $unitOfWork;
    private DeleteMilestoneUseCase $useCase;

    private const VALID_ACTOR_ID = 'f47ac10b-58cc-4372-a567-0e02b2c3d479';

    protected function setUp(): void
    {
        $this->repository = $this->createMock(MilestoneRepositoryInterface::class);
        $this->eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->unitOfWork = $this->createMock(UnitOfWorkInterface::class);

        $this->unitOfWork->method('execute')->willReturnCallback(fn($callback) => $callback());

        $this->useCase = new DeleteMilestoneUseCase(
            $this->repository,
            $this->eventDispatcher,
            $this->unitOfWork
        );
    }

    public function testDeleteSuccessfully(): void
    {
        $id = 10;
        $actorId = self::VALID_ACTOR_ID;
        
        $milestoneCode = MilestoneCode::fromString('1.1.1');

        $milestone = $this->createMock(Milestone::class);
        $milestone->method('getId')->willReturn($id);
        $milestone->method('getCriteriaId')->willReturn('1.1');
        $milestone->method('getCode')->willReturn($milestoneCode);
        $milestone->method('getOrder')->willReturn(1);
        $milestone->method('getName')->willReturn('Milestone A');

        $this->debug('PREPARE: Mocking Milestone for deletion', ['milestone_id' => $id]);

        $this->repository->expects($this->once())
            ->method('findOrFail')
            ->with($id)
            ->willReturn($milestone);

        $this->repository->expects($this->once())
            ->method('delete')
            ->with($milestone);

        $this->eventDispatcher->expects($this->once())->method('dispatch');

        $this->useCase->execute($id, $actorId);
        
        $this->debug('DELETE MILESTONE SUCCESS', ['id' => $id]);
    }

    public function testDeleteThrowsExceptionWhenNotFound(): void
    {
        $id = 999;
        
        $this->repository->method('findOrFail')
            ->with($id)
            ->willThrowException(new \Exception("Milestone not found"));

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Milestone not found");

        $this->repository->expects($this->never())->method('delete');
        $this->eventDispatcher->expects($this->never())->method('dispatch');

        $this->useCase->execute($id, self::VALID_ACTOR_ID);
        
        $this->debug('EXCEPTION EXPECTED: Finding non-existent ID', ['id' => $id]);
    }
}