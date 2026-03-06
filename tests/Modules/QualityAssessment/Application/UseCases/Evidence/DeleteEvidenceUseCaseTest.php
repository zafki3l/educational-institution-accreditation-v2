<?php

namespace Tests\Unit\Modules\QualityAssessment\Application\UseCases\Evidence;

use App\Modules\QualityAssessment\Application\UseCases\Evidence\DeleteEvidenceUseCase;
use App\Modules\QualityAssessment\Domain\Repositories\EvidenceRepositoryInterface;
use App\Shared\Logging\LoggerInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TraitHelper\DebugHelper;

final class DeleteEvidenceUseCaseTest extends TestCase
{
    use DebugHelper;

    private EvidenceRepositoryInterface&MockObject $repository;
    private LoggerInterface&MockObject $logger;
    private DeleteEvidenceUseCase $useCase;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(EvidenceRepositoryInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);

        $this->useCase = new DeleteEvidenceUseCase(
            $this->repository,
            $this->logger
        );
    }

    /**
     * Run: composer test -- --filter DeleteEvidenceUseCaseTest::testExecuteSuccessfully
     * 
     * @return void
     */
    public function testExecuteSuccessfully(): void
    {
        $evidenceId = 'H1.01.01.01';
        $actorId = 'user-admin-99';
        $expectedCriteriaId = '1.1';

        $this->debug('START', [
            'evidence_id' => $evidenceId,
            'actor' => $actorId
        ]);

        $this->repository->expects($this->once())
            ->method('delete')
            ->with($evidenceId)
            ->willReturnCallback(function($id) use ($expectedCriteriaId) {
                $this->debug('REPO_ACTION', ['id' => $id]);
                return $expectedCriteriaId;
            });

        $this->logger->expects($this->once())
            ->method('write')
            ->with(
                'info',
                'delete',
                $this->stringContains($evidenceId), 
                $actorId,
                $this->callback(function($context) use ($evidenceId, $expectedCriteriaId) {
                    $this->debug('LOG_CONTEXT',  $context);
                    return $context['id'] === $evidenceId && $context['criteria_id'] === $expectedCriteriaId;
                })
            );

        $this->debug('EXECUTE', 'Chạy DeleteEvidenceUseCase...');
        $result = $this->useCase->execute($evidenceId, $actorId);

        $this->assertEquals($expectedCriteriaId, $result);
        $this->debug('END', ['returned_criteria_id' => $result]);
    }
}