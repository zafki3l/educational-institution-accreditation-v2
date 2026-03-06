<?php

namespace Tests\Unit\Modules\QualityAssessment\Application\UseCases\Standard;

use App\Modules\QualityAssessment\Application\UseCases\Standard\DeleteStandardUseCase;
use App\Modules\QualityAssessment\Domain\Entities\Standard;
use App\Modules\QualityAssessment\Domain\Repositories\StandardRepositoryInterface;
use App\Shared\Logging\LoggerInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TraitHelper\DebugHelper;

final class DeleteStandardUseCaseTest extends TestCase
{
    use DebugHelper;

    private StandardRepositoryInterface&MockObject $repository;
    private LoggerInterface&MockObject $logger;
    private DeleteStandardUseCase $useCase;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(StandardRepositoryInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->useCase = new DeleteStandardUseCase($this->repository, $this->logger);
    }

    /**
     * Run: composer test -- --filter DeleteStandardUseCaseTest::testDeleteSuccessfully
     * 
     * @return void
     */
    public function testDeleteSuccessfully(): void
    {
        $id = '1';
        $actorId = 'admin-uuid';
        
        $standard = $this->createMock(Standard::class);
        $standard->method('getId')->willReturn($id);
        $standard->method('getName')->willReturn('Tiêu chuẩn Test');
        $standard->method('getDepartmentId')->willReturn('DEPT-01');

        $this->repository->expects($this->once())
            ->method('findOrFail')
            ->with($id)
            ->willReturn($standard);

        $this->repository->expects($this->once())
            ->method('delete')
            ->with($standard);

        $this->logger->expects($this->once())
            ->method('write')
            ->willReturnCallback(function ($level, $action, $msg, $actor, $context) use ($id) {
                $this->debug('LOG DATA CHECK', [
                    'message' => $msg,
                    'context_id' => $context['id'],
                    'context_name' => $context['name']
                ]);
                return true;
            });

        $this->useCase->execute($id, $actorId);
    }

    /**
     * Run: composer test -- --filter DeleteStandardUseCaseTest::testDeleteThrowsExceptionWhenNotFound
     * 
     * @return void
     */
    public function testDeleteThrowsExceptionWhenNotFound(): void
    {
        $invalidId = '999';
        
        $this->repository->method('findOrFail')
            ->willThrowException(new \Exception("Standard not found"));

        $this->expectException(\Exception::class);

        $this->repository->expects($this->never())->method('delete');
        $this->logger->expects($this->never())->method('write');

        $this->useCase->execute($invalidId, 'admin-uuid');
    }
}