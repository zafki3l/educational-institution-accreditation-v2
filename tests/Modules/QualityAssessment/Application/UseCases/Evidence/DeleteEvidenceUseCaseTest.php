<?php

namespace Tests\Unit\Modules\QualityAssessment\Application\UseCases\Evidence;

use App\Modules\QualityAssessment\Application\Readers\MilestoneReaderInterface;
use App\Modules\QualityAssessment\Application\UseCases\Evidence\DeleteEvidenceUseCase;
use App\Modules\QualityAssessment\Domain\Entities\Evidence;
use App\Modules\QualityAssessment\Domain\Events\Evidence\EvidenceDeleted;
use App\Modules\QualityAssessment\Domain\Exception\Criteria\CriteriaEmptyIdException;
use App\Modules\QualityAssessment\Domain\Exception\Evidence\EvidencePermissionAccessDeniedException;
use App\Modules\QualityAssessment\Domain\Repositories\EvidenceRepositoryInterface;
use App\Modules\QualityAssessment\Domain\Services\EvidencePermissionCheckerInterface;
use App\Modules\QualityAssessment\Domain\ValueObjects\Evidence\EvidenceId;
use App\Shared\Contracts\Events\EventDispatcherInterface;
use App\Shared\Contracts\UnitOfWork\UnitOfWorkInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

final class DeleteEvidenceUseCaseTest extends TestCase
{
    private EvidenceRepositoryInterface&MockObject $repository;
    private EvidencePermissionCheckerInterface&MockObject $permissionChecker;
    private MilestoneReaderInterface&MockObject $milestoneReader;
    private EventDispatcherInterface&MockObject $eventDispatcher;
    private UnitOfWorkInterface&MockObject $unitOfWork;
    private DeleteEvidenceUseCase $useCase;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(EvidenceRepositoryInterface::class);
        $this->permissionChecker = $this->createMock(EvidencePermissionCheckerInterface::class);
        $this->milestoneReader = $this->createMock(MilestoneReaderInterface::class);
        $this->eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->unitOfWork = $this->createMock(UnitOfWorkInterface::class);

        $this->unitOfWork->method('execute')->willReturnCallback(fn($callback) => $callback());

        $this->useCase = new DeleteEvidenceUseCase(
            $this->repository,
            $this->permissionChecker,
            $this->milestoneReader,
            $this->eventDispatcher,
            $this->unitOfWork
        );
    }

    public function testExecuteSuccessfully(): void
    {
        $criteriaId = '1.1';
        $evidenceIdStr = 'H1.01.01.01';
        $actorId = 'user-admin-99';
        $milestoneId = 10;
        $milestoneCode = 'MS_CODE_01';

        $evidence = $this->createMock(Evidence::class);
        $evidence->method('getId')->willReturn(EvidenceId::fromString($evidenceIdStr));
        $evidence->method('getMilestoneId')->willReturn($milestoneId);
        $evidence->method('getName')->willReturn('Test Evidence');

        $this->permissionChecker->method('check')->with($criteriaId, $actorId)->willReturn(true);
        $this->repository->method('findOrFail')->with($evidenceIdStr)->willReturn($evidence);
        $this->milestoneReader->method('getCodeById')->with($milestoneId)->willReturn($milestoneCode);

        $this->repository->expects($this->once())
            ->method('delete')
            ->with($evidenceIdStr);

        $this->eventDispatcher->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(EvidenceDeleted::class));

        $this->useCase->execute($criteriaId, $evidenceIdStr, $actorId);
    }

    public function testThrowsExceptionWhenCriteriaIdIsEmpty(): void
    {
        $this->expectException(CriteriaEmptyIdException::class);
        
        $this->useCase->execute('', 'H1.01.01.01', 'actor-id');
    }

    public function testThrowsExceptionWhenPermissionIsDenied(): void
    {
        $criteriaId = '1.1';
        $actorId = 'actor-id';

        $this->permissionChecker->method('check')->willReturn(false);

        $this->expectException(EvidencePermissionAccessDeniedException::class);

        $this->useCase->execute($criteriaId, 'H1.01.01.01', $actorId);
    }
}