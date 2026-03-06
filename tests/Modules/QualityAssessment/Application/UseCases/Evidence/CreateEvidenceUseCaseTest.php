<?php

namespace Tests\Unit\Modules\QualityAssessment\Application\UseCases\Evidence;

use App\Modules\QualityAssessment\Application\Requests\Evidence\CreateEvidenceRequestInterface;
use App\Modules\QualityAssessment\Application\UseCases\Evidence\CreateEvidenceUseCase;
use App\Modules\QualityAssessment\Domain\Entities\Evidence;
use App\Modules\QualityAssessment\Domain\Exception\Evidence\EvidencePermissionAccessDeniedException;
use App\Modules\QualityAssessment\Domain\Repositories\EvidenceRepositoryInterface;
use App\Modules\QualityAssessment\Domain\Services\EvidenceFileUploaderInterface;
use App\Modules\QualityAssessment\Domain\Services\EvidenceIdExistsCheckerInterface;
use App\Modules\QualityAssessment\Domain\Services\EvidenceIssuedDateEmptyCheckerInterface;
use App\Modules\QualityAssessment\Domain\Services\EvidencePermissionCheckerInterface;
use App\Shared\Logging\LoggerInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TraitHelper\DebugHelper;

final class CreateEvidenceUseCaseTest extends TestCase
{
    use DebugHelper;
    
    private EvidenceRepositoryInterface&MockObject $repository;
    private EvidenceFileUploaderInterface&MockObject $fileUploader;
    private EvidenceIdExistsCheckerInterface&MockObject $idChecker;
    private EvidenceIssuedDateEmptyCheckerInterface&MockObject $dateChecker;
    private EvidencePermissionCheckerInterface&MockObject $permissionChecker;
    private LoggerInterface&MockObject $logger;
    private CreateEvidenceUseCase $useCase;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(EvidenceRepositoryInterface::class);
        $this->fileUploader = $this->createMock(EvidenceFileUploaderInterface::class);
        $this->idChecker = $this->createMock(EvidenceIdExistsCheckerInterface::class);
        $this->dateChecker = $this->createMock(EvidenceIssuedDateEmptyCheckerInterface::class);
        $this->permissionChecker = $this->createMock(EvidencePermissionCheckerInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);

        $this->useCase = new CreateEvidenceUseCase(
            $this->repository,
            $this->fileUploader,
            $this->idChecker,
            $this->dateChecker,
            $this->permissionChecker,
            $this->logger
        );
    }

    /**
     * Run: composer test -- --filter CreateEvidenceUseCaseTest::testExecuteSuccessfully
     * 
     * @return void
     */
    public function testExecuteSuccessfully(): void
    {
        $actorId = 'actor-1';
        $this->debug('TestExecuteSuccessfully', ['actor' => $actorId]);

        $request = $this->createMock(CreateEvidenceRequestInterface::class);
        $request->method('getId')->willReturn('H1.01.01.01');
        $request->method('getName')->willReturn('Tên minh chứng');
        $request->method('getIssuedDate')->willReturn('2024-01-01');
        $request->method('getCriteriaId')->willReturn('1.1');
        $request->method('getMilestoneId')->willReturn(1); 
        $request->method('getFile')->willReturn(['error' => UPLOAD_ERR_OK]);
        $request->method('getIssuingAuthority')->willReturn('Cơ quan ban hành');
        $request->method('getDocumentNumber')->willReturn('Số hiệu 123');

        $this->permissionChecker->expects($this->once())
            ->method('check')
            ->willReturnCallback(function($criteriaId, $id) {
                $this->debug('CHECK', ['criteria' => $criteriaId, 'actor' => $id]);
            });

        $this->idChecker->method('check')->willReturn(false);
        $this->dateChecker->method('check')->willReturn(false);
        
        $this->fileUploader->method('upload')
            ->willReturnCallback(function($file, $id) {
                $this->debug('UPLOAD', ['target_id' => $id]);
                return 'path/to/file.pdf';
            });

        $this->repository->expects($this->once())
            ->method('create')
            ->with($this->callback(function (Evidence $evidence) {
                $this->debug('ENTITY_FINAL', [
                    'id' => $evidence->getId()->value(),
                    'file_url' => $evidence->getFileUrl(),
                    'issued_date' => $evidence->getIssuedDate()->format('Y-m-d')
                ]);
                return true;
            }));

        $this->logger->expects($this->once())
            ->method('write')
            ->willReturnCallback(function($level, $action, $message, $actor, $context) {
                $this->debug('SYSTEM_LOG', [
                    'level' => $level,
                    'action' => $action,
                    'msg' => $message,
                    'context_id' => $context['id']
                ]);
                return true;
            });

        $this->useCase->execute($request, $actorId);
        
        $this->debug('END', 'Kết thúc testExecuteSuccessfully - SUCCESS');
    }

    /**
     * Run: composer test -- --filter CreateEvidenceUseCaseTest::testExecuteThrowsExceptionWhenPermissionDenied
     * 
     * @return void
     */
    public function testExecuteThrowsExceptionWhenPermissionDenied(): void
    {
        $this->debug('START', 'Bắt đầu test lỗi Permission Denied');

        $request = $this->createMock(CreateEvidenceRequestInterface::class);
        $request->method('getCriteriaId')->willReturn('1.1');
        
        $this->permissionChecker->method('check')
            ->willThrowException(new EvidencePermissionAccessDeniedException());

        $this->expectException(EvidencePermissionAccessDeniedException::class);

        try {
            $this->useCase->execute($request, 'actor-1');
        } catch (EvidencePermissionAccessDeniedException $e) {
            $this->debug('CATCHED', ['message' => $e->getMessage()]);
            throw $e;
        }
    }
}