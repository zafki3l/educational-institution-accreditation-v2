<?php

namespace Tests\Unit\Modules\QualityAssessment\Application\UseCases\Evidence;

use App\Modules\QualityAssessment\Application\Readers\MilestoneReaderInterface;
use App\Modules\QualityAssessment\Application\Requests\Evidence\CreateEvidenceRequestInterface;
use App\Modules\QualityAssessment\Application\UseCases\Evidence\CreateEvidenceUseCase;
use App\Modules\QualityAssessment\Domain\Events\Evidence\EvidenceCreated;
use App\Modules\QualityAssessment\Domain\Exception\Criteria\CriteriaEmptyIdException;
use App\Modules\QualityAssessment\Domain\Exception\Evidence\EvidenceIdExistsException;
use App\Modules\QualityAssessment\Domain\Exception\Evidence\EvidencePermissionAccessDeniedException;
use App\Modules\QualityAssessment\Domain\Repositories\EvidenceRepositoryInterface;
use App\Modules\QualityAssessment\Domain\Services\EvidenceFileUploaderInterface;
use App\Modules\QualityAssessment\Domain\Services\EvidenceIdExistsCheckerInterface;
use App\Modules\QualityAssessment\Domain\Services\EvidenceIssuedDateEmptyCheckerInterface;
use App\Modules\QualityAssessment\Domain\Services\EvidencePermissionCheckerInterface;
use App\Shared\Contracts\Events\EventDispatcherInterface;
use App\Shared\Contracts\UnitOfWork\UnitOfWorkInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class CreateEvidenceUseCaseTest extends TestCase
{
    private EvidenceRepositoryInterface&MockObject $repository;
    private EvidenceFileUploaderInterface&MockObject $fileUploader;
    private EvidenceIdExistsCheckerInterface&MockObject $idChecker;
    private EvidenceIssuedDateEmptyCheckerInterface&MockObject $dateChecker;
    private EvidencePermissionCheckerInterface&MockObject $permissionChecker;
    private MilestoneReaderInterface&MockObject $milestoneReader;
    private EventDispatcherInterface&MockObject $eventDispatcher;
    private UnitOfWorkInterface&MockObject $unitOfWork;
    private CreateEvidenceUseCase $useCase;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(EvidenceRepositoryInterface::class);
        $this->fileUploader = $this->createMock(EvidenceFileUploaderInterface::class);
        $this->idChecker = $this->createMock(EvidenceIdExistsCheckerInterface::class);
        $this->dateChecker = $this->createMock(EvidenceIssuedDateEmptyCheckerInterface::class);
        $this->permissionChecker = $this->createMock(EvidencePermissionCheckerInterface::class);
        $this->milestoneReader = $this->createMock(MilestoneReaderInterface::class);
        $this->eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->unitOfWork = $this->createMock(UnitOfWorkInterface::class);

        // Ensure UnitOfWork executes the closure
        $this->unitOfWork->method('execute')->willReturnCallback(fn($callback) => $callback());

        $this->useCase = new CreateEvidenceUseCase(
            $this->repository,
            $this->fileUploader,
            $this->idChecker,
            $this->dateChecker,
            $this->permissionChecker,
            $this->milestoneReader,
            $this->eventDispatcher,
            $this->unitOfWork
        );
    }

    public function testExecuteSuccessfully(): void
    {
        $actorId = 'user-123';
        $request = $this->createMock(CreateEvidenceRequestInterface::class);

        $request->method('getId')->willReturn('H1.01.01.01');
        $request->method('getName')->willReturn('Evidence Name');
        $request->method('getCriteriaId')->willReturn('1.1');
        $request->method('getMilestoneId')->willReturn(1); // Changed to int
        $request->method('getIssuedDate')->willReturn('2024-01-01');
        $request->method('getDocumentNumber')->willReturn('DOC-123');
        $request->method('getIssuingAuthority')->willReturn('Authority');
        $request->method('getFile')->willReturn(['error' => UPLOAD_ERR_OK, 'tmp_name' => '/tmp/file']);

        $this->permissionChecker->method('check')->willReturn(true);
        $this->idChecker->method('check')->willReturn(false);
        $this->dateChecker->method('check')->willReturn(false);
        $this->milestoneReader->method('getCodeById')->willReturn('MS_CODE_01');
        $this->fileUploader->method('upload')->willReturn('evidence_file.pdf');

        $this->repository->expects($this->once())->method('create');
        $this->eventDispatcher->expects($this->once())->method('dispatch')
            ->with($this->isInstanceOf(EvidenceCreated::class));

        $this->useCase->execute($request, $actorId);
    }

    public function testThrowsExceptionWhenCriteriaIdIsEmpty(): void
    {
        $request = $this->createMock(CreateEvidenceRequestInterface::class);
        $request->method('getCriteriaId')->willReturn('');

        $this->expectException(CriteriaEmptyIdException::class);

        $this->useCase->execute($request, 'actor-id');
    }

    public function testThrowsExceptionWhenPermissionIsDenied(): void
    {
        $request = $this->createMock(CreateEvidenceRequestInterface::class);
        $request->method('getCriteriaId')->willReturn('1.1');

        $this->permissionChecker->method('check')->willReturn(false);

        $this->expectException(EvidencePermissionAccessDeniedException::class);

        $this->useCase->execute($request, 'actor-id');
    }

    public function testThrowsExceptionWhenEvidenceIdAlreadyExists(): void
    {
        $request = $this->createMock(CreateEvidenceRequestInterface::class);
        $request->method('getCriteriaId')->willReturn('1.1');
        $request->method('getId')->willReturn('H1.01.01.01');

        $this->permissionChecker->method('check')->willReturn(true);
        $this->idChecker->method('check')->willReturn(true);

        $this->expectException(EvidenceIdExistsException::class);

        $this->useCase->execute($request, 'actor-id');
    }

    public function testDoesNotUploadFileWhenUploadHasError(): void
    {
        $request = $this->createMock(CreateEvidenceRequestInterface::class);
        $request->method('getCriteriaId')->willReturn('1.1');
        $request->method('getName')->willReturn('Evidence name');
        $request->method('getId')->willReturn('H1.01.01.01');
        $request->method('getMilestoneId')->willReturn(1);
        $request->method('getIssuingAuthority')->willReturn('HD150');
        $request->method('getFile')->willReturn(['error' => UPLOAD_ERR_NO_FILE]);

        $this->permissionChecker->method('check')->willReturn(true);
        $this->idChecker->method('check')->willReturn(false);
        $this->dateChecker->method('check')->willReturn(true);
        $this->milestoneReader->method('getCodeById')->willReturn('MS_CODE_01');

        $this->fileUploader->expects($this->never())->method('upload');
        $this->repository->expects($this->once())->method('create');

        $this->useCase->execute($request, 'actor-id');
    }
}