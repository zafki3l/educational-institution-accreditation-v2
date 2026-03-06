<?php

namespace Tests\Unit\Modules\QualityAssessment\Application\UseCases\Milestone;

use App\Modules\QualityAssessment\Application\UseCases\Milestone\DeleteMilestoneUseCase;
use App\Modules\QualityAssessment\Domain\Entities\Milestone;
use App\Modules\QualityAssessment\Domain\Repositories\MilestoneRepositoryInterface;
use App\Modules\QualityAssessment\Domain\ValueObjects\Milestone\MilestoneCode;
use App\Shared\Logging\LoggerInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TraitHelper\DebugHelper;

final class DeleteMilestoneUseCaseTest extends TestCase
{
    use DebugHelper;

    private MilestoneRepositoryInterface&MockObject $repository;
    private LoggerInterface&MockObject $logger;
    private DeleteMilestoneUseCase $useCase;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(MilestoneRepositoryInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->useCase = new DeleteMilestoneUseCase($this->repository, $this->logger);
    }

    /**
     * Run: composer test -- --filter DeleteMilestoneUseCaseTest::testDeleteSuccessfully
     * 
     * @return void
     */
    public function testDeleteSuccessfully(): void
    {
        $id = 10;
        $actorId = 'user-admin';
        
        $milestoneCode = MilestoneCode::fromString('1.1.1');

        $milestone = $this->createMock(Milestone::class);
        $milestone->method('getId')->willReturn($id);
        $milestone->method('getCriteriaId')->willReturn('1.1');
        $milestone->method('getCode')->willReturn($milestoneCode);
        $milestone->method('getOrder')->willReturn(1);
        $milestone->method('getName')->willReturn('Mốc A');

        $this->debug('PREPARE: Mocking Milestone for deletion', ['milestone_id' => $id]);

        $this->repository->expects($this->once())
            ->method('findOrFail')
            ->with($id)
            ->willReturn($milestone);

        $this->repository->expects($this->once())
            ->method('delete')
            ->with($milestone);

        $this->logger->expects($this->once())
            ->method('write')
            ->willReturnCallback(function($level, $action, $msg, $actor, $context) use ($id) {
                $this->debug('LOGGING: Deletion log check', [
                    'message' => $msg,
                    'milestone_id_in_log' => $context['id']
                ]);
                $this->assertEquals($id, $context['id']);
                return true;
            });

        $this->useCase->execute($id, $actorId);
    }

    /**
     * Run: composer test -- --filter DeleteMilestoneUseCaseTest::testDeleteThrowsExceptionWhenNotFound
     * 
     * @return void
     */
    public function testDeleteThrowsExceptionWhenNotFound(): void
    {
        $id = 999;
        
        $this->repository->method('findOrFail')
            ->with($id)
            ->willThrowException(new \Exception("Milestone not found"));

        $this->expectException(\Exception::class);

        $this->debug('EXCEPTION EXPECTED: Finding non-existent ID', ['id' => $id]);

        $this->repository->expects($this->never())->method('delete');
        $this->logger->expects($this->never())->method('write');

        $this->useCase->execute($id, 'user-123');
    }
}