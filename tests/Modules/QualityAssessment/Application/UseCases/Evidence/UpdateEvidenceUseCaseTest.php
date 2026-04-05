<?php

namespace Tests\Unit\Modules\QualityAssessment\Application\UseCases\Evidence;

use App\Modules\QualityAssessment\Application\Readers\MilestoneReaderInterface;
use App\Modules\QualityAssessment\Application\Requests\Evidence\UpdateEvidenceRequestInterface;
use App\Modules\QualityAssessment\Application\UseCases\Evidence\UpdateEvidenceUseCase;
use App\Modules\QualityAssessment\Domain\Entities\Evidence;
use App\Modules\QualityAssessment\Domain\Events\Evidence\EvidenceUpdated;
use App\Modules\QualityAssessment\Domain\Exception\Criteria\CriteriaEmptyIdException;
use App\Modules\QualityAssessment\Domain\Exception\Evidence\EvidencePermissionAccessDeniedException;
use App\Modules\QualityAssessment\Domain\Repositories\EvidenceRepositoryInterface;
use App\Modules\QualityAssessment\Domain\Services\EvidenceFileUploaderInterface;
use App\Modules\QualityAssessment\Domain\Services\EvidencePermissionCheckerInterface;
use App\Modules\QualityAssessment\Domain\ValueObjects\Evidence\EvidenceId;
use App\Shared\Contracts\Events\EventDispatcherInterface;
use App\Shared\Contracts\UnitOfWork\UnitOfWorkInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use DateTimeImmutable;

final class UpdateEvidenceUseCaseTest extends TestCase
{
    private EvidenceRepositoryInterface&MockObject $repository;
    private EvidenceFileUploaderInterface&MockObject $fileUploader;
    private EvidencePermissionCheckerInterface&MockObject $permissionChecker;
    private MilestoneReaderInterface&MockObject $milestoneReader;
    private EventDispatcherInterface&MockObject $eventDispatcher;
    private UnitOfWorkInterface&MockObject $unitOfWork;
    private UpdateEvidenceUseCase $useCase;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(EvidenceRepositoryInterface::class);
        $this->fileUploader = $this->createMock(EvidenceFileUploaderInterface::class);
        $this->permissionChecker = $this->createMock(EvidencePermissionCheckerInterface::class);
        $this->milestoneReader = $this->createMock(MilestoneReaderInterface::class);
        $this->eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->unitOfWork = $this->createMock(UnitOfWorkInterface::class);

        $this->unitOfWork->method('execute')->willReturnCallback(fn($callback) => $callback());

        $this->useCase = new UpdateEvidenceUseCase(
            $this->repository,
            $this->fileUploader,
            $this->permissionChecker,
            $this->milestoneReader,
            $this->eventDispatcher,
            $this->unitOfWork
        );
    }

    public function testExecuteSuccessfullyWithChanges(): void
    {
        $actorId = 'user-update-01';
        $evidenceId = 'H1.01.01.01';
        $criteriaId = 'CRIT-123';

        $request = $this->createMock(UpdateEvidenceRequestInterface::class);
        $request->method('getCriteriaId')->willReturn($criteriaId);
        $request->method('getId')->willReturn($evidenceId);
        $request->method('getName')->willReturn('Tên mới');
        $request->method('getIssuedDate')->willReturn('2024-02-02');
        $request->method('getDocumentNumber')->willReturn('456/QD');
        $request->method('getIssuingAuthority')->willReturn('So GD');
        $request->method('getMilestoneId')->willReturn(2);
        $request->method('getFile')->willReturn(['error' => UPLOAD_ERR_OK]);

        $evidence = $this->createMock(Evidence::class);
        $evidence->method('getId')->willReturn(EvidenceId::fromString($evidenceId));
        $evidence->method('getIssuedDate')->willReturn(new DateTimeImmutable('2023-01-01'));
        $evidence->method('getFileUrl')->willReturn('old_path.pdf');
        
        $evidence->method('hasChanges')->willReturn(true);
        $evidence->method('getChanges')->willReturn([
            'name' => ['old' => 'Old name', 'new' => 'New name'],
            'milestone_id' => ['old' => 1, 'new' => 2]
        ]);

        $this->permissionChecker->method('check')->willReturn(true);
        $this->repository->method('findOrFail')->with($evidenceId)->willReturn($evidence);
        $this->fileUploader->method('upload')->willReturn('new_path.pdf');
        
        $this->milestoneReader->method('getCodeById')->willReturnMap([
            [1, '1.1.1'],
            [2, '1.1.2'],
        ]);

        $this->repository->expects($this->once())->method('update')->with($evidence);
        $this->repository->expects($this->once())->method('updateMilestoneLink')->with($evidence);
        $this->eventDispatcher->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(EvidenceUpdated::class));

        $this->useCase->execute($request, $actorId);
    }

    public function testExecuteReturnsEarlyWhenNoChangesDetected(): void
    {
        $request = $this->createMock(UpdateEvidenceRequestInterface::class);
        $request->method('getCriteriaId')->willReturn('CRIT-123');
        $request->method('getFile')->willReturn(['error' => UPLOAD_ERR_NO_FILE]);

        $evidence = $this->createMock(Evidence::class);
        $evidence->method('hasChanges')->willReturn(false);

        $this->permissionChecker->method('check')->willReturn(true);
        $this->repository->method('findOrFail')->willReturn($evidence);

        $this->repository->expects($this->never())->method('update');
        $this->unitOfWork->expects($this->never())->method('execute');

        $this->useCase->execute($request, 'actor-1');
    }

    public function testThrowsExceptionWhenCriteriaIdIsEmpty(): void
    {
        $request = $this->createMock(UpdateEvidenceRequestInterface::class);
        $request->method('getCriteriaId')->willReturn('');

        $this->expectException(CriteriaEmptyIdException::class);

        $this->useCase->execute($request, 'actor-1');
    }

    public function testThrowsExceptionWhenPermissionIsDenied(): void
    {
        $request = $this->createMock(UpdateEvidenceRequestInterface::class);
        $request->method('getCriteriaId')->willReturn('CRIT-123');

        $this->permissionChecker->method('check')->willReturn(false);

        $this->expectException(EvidencePermissionAccessDeniedException::class);

        $this->useCase->execute($request, 'actor-1');
    }
}