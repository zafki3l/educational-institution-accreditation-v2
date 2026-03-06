<?php

namespace Tests\Unit\Modules\QualityAssessment\Application\UseCases\Criteria;

use App\Modules\QualityAssessment\Application\Requests\Criteria\UpdateCriteriaRequestInterface;
use App\Modules\QualityAssessment\Application\UseCases\Criteria\UpdateCriteriaUseCase;
use App\Modules\QualityAssessment\Domain\Entities\Criteria;
use App\Modules\QualityAssessment\Domain\Repositories\CriteriaRepositoryInterface;
use App\Shared\Logging\LoggerInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TraitHelper\DebugHelper;

final class UpdateCriteriaUseCaseTest extends TestCase
{
    use DebugHelper;

    private CriteriaRepositoryInterface&MockObject $repository;
    private LoggerInterface&MockObject $logger;
    private UpdateCriteriaUseCase $useCase;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(CriteriaRepositoryInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->useCase = new UpdateCriteriaUseCase($this->repository, $this->logger);
    }

    /**
     * Run: composer test -- --filter UpdateCriteriaUseCaseTest::testUpdateCriteriaSuccessfully
     * 
     * @return void
     */
    public function testUpdateCriteriaSuccessfully(): void
    {
        $id = '1.1';
        $actorId = 'user-001';
        $newStandardId = '1';
        $newName = 'Tên tiêu chí sau khi cập nhật';

        $request = $this->createMock(UpdateCriteriaRequestInterface::class);
        $request->method('getId')->willReturn($id);
        $request->method('getStandardId')->willReturn($newStandardId);
        $request->method('getName')->willReturn($newName);

        $criteria = $this->createMock(Criteria::class);
        
        $this->debug('STEP 1: Finding existing Criteria', ['id' => $id]);

        $this->repository->expects($this->once())
            ->method('findOrFail')
            ->with($id)
            ->willReturn($criteria);

        $criteria->expects($this->once())
            ->method('update')
            ->with($newStandardId, $newName);

        $this->repository->expects($this->once())
            ->method('save')
            ->with($criteria);

        $this->logger->expects($this->once())
            ->method('write')
            ->willReturnCallback(function($level, $action, $msg) {
                $this->debug('STEP 2: Logging update action', ['message' => $msg]);
                return true;
            });

        $this->useCase->execute($request, $actorId);
    }

    /**
     * Run: composer test -- --filter UpdateCriteriaUseCaseTest::testUpdateThrowsExceptionWhenCriteriaNotFound
     * 
     * @return void
     */
    public function testUpdateThrowsExceptionWhenCriteriaNotFound(): void
    {
        $request = $this->createMock(UpdateCriteriaRequestInterface::class);
        $request->method('getId')->willReturn('non-existent-id');

        $this->repository->method('findOrFail')
            ->willThrowException(new \Exception("Criteria not found"));

        $this->expectException(\Exception::class);

        $this->debug('EXPECTATION: Should stop before saving or logging', []);

        $this->repository->expects($this->never())->method('save');
        $this->logger->expects($this->never())->method('write');

        $this->useCase->execute($request, 'actor-1');
    }
}