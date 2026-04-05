<?php

namespace App\Modules\QualityAssessment\Application\UseCases\Evidence;

use App\Modules\QualityAssessment\Application\Readers\MilestoneReaderInterface;
use App\Modules\QualityAssessment\Domain\Events\Evidence\EvidenceDeleted;
use App\Modules\QualityAssessment\Domain\Exception\Criteria\CriteriaEmptyIdException;
use App\Modules\QualityAssessment\Domain\Exception\Evidence\EvidencePermissionAccessDeniedException;
use App\Modules\QualityAssessment\Domain\Repositories\EvidenceRepositoryInterface;
use App\Modules\QualityAssessment\Domain\Services\EvidencePermissionCheckerInterface;
use App\Shared\Contracts\Events\EventDispatcherInterface;
use App\Shared\Contracts\UnitOfWork\UnitOfWorkInterface;

final class DeleteEvidenceUseCase
{
    public function __construct(
        private EvidenceRepositoryInterface $repository,
        private EvidencePermissionCheckerInterface $evidencePermissionChecker,
        private MilestoneReaderInterface $milestoneReader,
        private EventDispatcherInterface $eventDispatcher,
        private UnitOfWorkInterface $unitOfWork
    ) {}

    public function execute(string $criteria_id, string $id, string $actor_id): void
    {
        if ($criteria_id === '') {
            throw new CriteriaEmptyIdException();
        }

        if (!$this->evidencePermissionChecker->check($criteria_id, $actor_id)) {
            throw new EvidencePermissionAccessDeniedException();
        }
        
        $evidence = $this->repository->findOrFail($id);

        $milestone_code = $this->milestoneReader->getCodeById($evidence->getMilestoneId());

        $this->unitOfWork->execute(function () use ($evidence, $milestone_code, $actor_id) {
            $this->repository->delete($evidence->getId()->value());

            $this->eventDispatcher->dispatch(new EvidenceDeleted(
                $evidence->getId()->value(),
                $evidence->getName(),
                $evidence->getDocumentNumber(),
                $evidence->getIssuedDate()?->format('Y-m-d'),
                $evidence->getIssuingAuthority(),
                $milestone_code,
                $evidence->getFileUrl(),
                $actor_id
            ));
        });
    }
}