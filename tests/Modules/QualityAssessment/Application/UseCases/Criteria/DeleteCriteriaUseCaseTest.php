<?php

namespace Tests\Unit\Modules\QualityAssessment\Application\UseCases\Criteria;

use App\Modules\QualityAssessment\Application\UseCases\Criteria\DeleteCriteriaUseCase;
use App\Modules\QualityAssessment\Domain\Entities\Criteria;
use App\Modules\QualityAssessment\Domain\Repositories\CriteriaRepositoryInterface;
use App\Shared\Logging\LoggerInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TraitHelper\DebugHelper;

final class DeleteCriteriaUseCaseTest extends TestCase
{
    use DebugHelper;

    private CriteriaRepositoryInterface&MockObject $repository;
    private LoggerInterface&MockObject $logger;
    private DeleteCriteriaUseCase $useCase;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(CriteriaRepositoryInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->useCase = new DeleteCriteriaUseCase($this->repository, $this->logger);
    }

    /**
     * Run: composer test -- --filter DeleteCriteriaUseCaseTest::testDeleteCriteriaSuccessfully
     * 
     * @return void
     */
    public function testDeleteCriteriaSuccessfully(): void
    {
        $id = '1.1';
        $actorId = 'admin-user';

        $criteria = $this->createMock(Criteria::class);
        $criteria->method('getId')->willReturn($id);
        $criteria->method('getName')->willReturn('Tiêu chí kiểm định');
        $criteria->method('getStandardId')->willReturn('1');

        $this->debug('STEP 1: Mock Criteria Prepared', ['id' => $id]);

        $this->repository->expects($this->once())
            ->method('findOrFail')
            ->with($id)
            ->willReturn($criteria);

        $this->repository->expects($this->once())
            ->method('delete')
            ->with($criteria);

        $this->logger->expects($this->once())
            ->method('write')
            ->willReturnCallback(function ($level, $action, $msg, $actor) use ($id) {
                $this->debug('STEP 2: Logger Called', ['msg' => $msg]);
                return true;
            });

        $this->useCase->execute($id, $actorId);
    }

    /**
     * Run: composer test -- --filter DeleteCriteriaUseCaseTest::testDeleteThrowsExceptionWhenCriteriaNotFound
     * 
     * @return void
     */
    public function testDeleteThrowsExceptionWhenCriteriaNotFound(): void
    {
        $invalidId = '9.9';
        
        $this->repository->method('findOrFail')
            ->with($invalidId)
            ->willThrowException(new \Exception("Criteria not found"));

        $this->expectException(\Exception::class);

        $this->debug('EXPECTATION: Should throw exception and stop execution', []);

        $this->repository->expects($this->never())->method('delete');
        $this->logger->expects($this->never())->method('write');

        $this->useCase->execute($invalidId, 'actor-1');
    }
}