<?php

namespace Tests\Unit\Modules\QualityAssessment\Application\UseCases\Milestone;

use App\Modules\QualityAssessment\Application\Requests\Milestone\CreateMilestoneRequestInterface;
use App\Modules\QualityAssessment\Application\UseCases\Milestone\CreateMilestoneUseCase;
use App\Modules\QualityAssessment\Domain\Entities\Milestone;
use App\Modules\QualityAssessment\Domain\Repositories\MilestoneRepositoryInterface;
use App\Modules\QualityAssessment\Domain\ValueObjects\Milestone\MilestoneCode;
use App\Shared\Logging\LoggerInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TraitHelper\DebugHelper;

final class CreateMilestoneUseCaseTest extends TestCase
{
    use DebugHelper;

    private MilestoneRepositoryInterface&MockObject $repository;
    private LoggerInterface&MockObject $logger;
    private CreateMilestoneUseCase $useCase;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(MilestoneRepositoryInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->useCase = new CreateMilestoneUseCase($this->repository, $this->logger);
    }

    /**
     * Run: composer test -- --filter CreateMilestoneUseCaseTest::testExecuteSuccessfully
     * @return void
     */
    public function testExecuteSuccessfully(): void
    {
        $actorId = 'user-123';
        $criteriaId = '1.1';
        $order = 2;
        $name = 'Hoàn thành báo cáo tự đánh giá';

        $request = $this->createMock(CreateMilestoneRequestInterface::class);
        $request->method('getCriteriaId')->willReturn($criteriaId);
        $request->method('getOrder')->willReturn($order);
        $request->method('getName')->willReturn($name);

        $persistedMilestone = $this->createMock(Milestone::class);
        $persistedMilestone->method('getId')->willReturn(99);
        $persistedMilestone->method('getCriteriaId')->willReturn($criteriaId);
        $persistedMilestone->method('getOrder')->willReturn($order);
        $persistedMilestone->method('getName')->willReturn($name);

        $persistedMilestone->method('getCode')->willReturn(
            MilestoneCode::fromString('1.1.2')
        );

        $this->debug('PREPARING REQUEST', ['criteria' => $criteriaId, 'order' => $order]);

        $this->repository->expects($this->once())
            ->method('create')
            ->with($this->isInstanceOf(Milestone::class))
            ->willReturn($persistedMilestone);

        $this->logger->expects($this->once())
            ->method('write')
            ->willReturnCallback(function($level, $action, $msg, $actor, $context) {
                $this->debug('LOG CHECK', ['log_context' => $context]);
                return true;
            });

        $result = $this->useCase->execute($request, $actorId);

        $this->assertSame($persistedMilestone, $result);
        $this->assertEquals(99, $result->getId());
        $this->assertEquals('1.1.2', $result->getCode()->value());
    }
}