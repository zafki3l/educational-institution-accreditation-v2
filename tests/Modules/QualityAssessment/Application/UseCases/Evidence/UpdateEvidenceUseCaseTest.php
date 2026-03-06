<?php

namespace Tests\Unit\Modules\QualityAssessment\Application\UseCases\Evidence;

use App\Modules\QualityAssessment\Application\Requests\Evidence\UpdateEvidenceRequestInterface;
use App\Modules\QualityAssessment\Application\UseCases\Evidence\UpdateEvidenceUseCase;
use App\Modules\QualityAssessment\Domain\Entities\Evidence;
use App\Modules\QualityAssessment\Domain\Exception\Evidence\EvidenceEmptyIssuedDateException;
use App\Modules\QualityAssessment\Domain\Repositories\EvidenceRepositoryInterface;
use App\Modules\QualityAssessment\Domain\Services\EvidenceFileUploaderInterface;
use App\Modules\QualityAssessment\Domain\Services\EvidenceIssuedDateEmptyCheckerInterface;
use App\Shared\Logging\LoggerInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TraitHelper\DebugHelper;

final class UpdateEvidenceUseCaseTest extends TestCase
{
    use DebugHelper;

    private EvidenceRepositoryInterface&MockObject $repository;
    private EvidenceFileUploaderInterface&MockObject $fileUploader;
    private EvidenceIssuedDateEmptyCheckerInterface&MockObject $dateChecker;
    private LoggerInterface&MockObject $logger;
    private UpdateEvidenceUseCase $useCase;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(EvidenceRepositoryInterface::class);
        $this->fileUploader = $this->createMock(EvidenceFileUploaderInterface::class);
        $this->dateChecker = $this->createMock(EvidenceIssuedDateEmptyCheckerInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);

        $this->useCase = new UpdateEvidenceUseCase(
            $this->repository,
            $this->fileUploader,
            $this->dateChecker,
            $this->logger
        );
    }

    /**
     * Run: composer test -- --filter UpdateEvidenceUseCaseTest::testExecuteSuccessfullyWithNewFile
     * 
     * @return void
     */
    public function testExecuteSuccessfullyWithNewFile(): void
    {
        $actorId = 'user-update-01';
        $this->debug('START', 'Bắt đầu testUpdateSuccessfullyWithNewFile');

        $request = $this->createMock(UpdateEvidenceRequestInterface::class);
        $request->method('getId')->willReturn('H1.01.01.01');
        $request->method('getName')->willReturn('Tên minh chứng cập nhật');
        $request->method('getIssuedDate')->willReturn('2024-02-02');
        $request->method('getDocumentNumber')->willReturn('456/QĐ');
        $request->method('getIssuingAuthority')->willReturn('Sở GD');
        $request->method('getMilestoneId')->willReturn(2);

        $request->method('getFile')->willReturn(['error' => UPLOAD_ERR_OK]);

        $this->dateChecker->method('check')->willReturn(false);

        $this->fileUploader->expects($this->once())
            ->method('upload')
            ->willReturn('new_evidence_path.pdf');

        $expectedCriteriaId = 'CRIT-123';
        $this->repository->expects($this->once())
            ->method('update')
            ->with($this->callback(function (Evidence $evidence) {
                $this->debug('REPO_UPDATE', [
                    'id' => $evidence->getId()->value(),
                    'new_file' => $evidence->getFileUrl()
                ]);
                return $evidence->getFileUrl() === 'new_evidence_path.pdf';
            }))
            ->willReturn($expectedCriteriaId);

        $this->logger->expects($this->once())
            ->method('write')
            ->with('info', 'delete', $this->anything(), $actorId);

        $result = $this->useCase->execute($request, $actorId);

        $this->assertEquals($expectedCriteriaId, $result);
        $this->debug('END', ['criteria_id' => $result]);
    }

    /**
     * Run: composer test -- --filter UpdateEvidenceUseCaseTest::testExecuteThrowsExceptionWhenDateEmpty
     * 
     * @return void
     */
    public function testExecuteThrowsExceptionWhenDateEmpty(): void
    {
        $this->debug('START', 'Bắt đầu test lỗi ngày ban hành trống');

        $request = $this->createMock(UpdateEvidenceRequestInterface::class);
        $request->method('getIssuedDate')->willReturn('');

        $this->dateChecker->method('check')->willReturn(true);

        $this->expectException(EvidenceEmptyIssuedDateException::class);

        $this->useCase->execute($request, 'actor-1');
    }
}