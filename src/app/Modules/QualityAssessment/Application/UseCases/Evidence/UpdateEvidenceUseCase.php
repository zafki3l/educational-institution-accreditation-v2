<?php

namespace App\Modules\QualityAssessment\Application\UseCases\Evidence;

use App\Modules\QualityAssessment\Application\Readers\MilestoneReaderInterface;
use App\Modules\QualityAssessment\Application\Requests\Evidence\UpdateEvidenceRequestInterface;
use App\Modules\QualityAssessment\Domain\Events\Evidence\EvidenceUpdated;
use App\Modules\QualityAssessment\Domain\Exception\Criteria\CriteriaEmptyIdException;
use App\Modules\QualityAssessment\Domain\Exception\Evidence\EvidencePermissionAccessDeniedException;
use App\Modules\QualityAssessment\Domain\Repositories\EvidenceRepositoryInterface;
use App\Modules\QualityAssessment\Domain\Services\EvidenceFileUploaderInterface;
use App\Modules\QualityAssessment\Domain\Services\EvidencePermissionCheckerInterface;
use App\Shared\Contracts\Events\EventDispatcherInterface;
use App\Shared\Contracts\UnitOfWork\UnitOfWorkInterface;
use DateTimeImmutable;

final class UpdateEvidenceUseCase
{
    public function __construct(
        private EvidenceRepositoryInterface $repository,
        private EvidenceFileUploaderInterface $evidenceFileUploader,
        private EvidencePermissionCheckerInterface $evidencePermissionChecker,
        private MilestoneReaderInterface $milestoneReader,
        private EventDispatcherInterface $eventDispatcher,
        private UnitOfWorkInterface $unitOfWork
    ) {}

    public function execute(UpdateEvidenceRequestInterface $request, string $actor_id): void
    {
        if ($request->getCriteriaId() === '') {
            throw new CriteriaEmptyIdException();
        }

        if (!$this->evidencePermissionChecker->check($request->getCriteriaId(), $actor_id)) {
            throw new EvidencePermissionAccessDeniedException();
        }

        $evidence = $this->repository->findOrFail($request->getId());

        $issuedDate = $request->getIssuedDate() 
            ? new DateTimeImmutable($request->getIssuedDate()) 
            : $evidence->getIssuedDate();

        $file = ($request->getFile()['error'] === UPLOAD_ERR_OK) 
            ? $this->evidenceFileUploader->upload($request->getFile(), $request->getId())
            : $evidence->getFileUrl();

        $evidence->update(
            $request->getName(),
            $request->getDocumentNumber() ?: null,
            $issuedDate,
            $request->getIssuingAuthority(),
            $request->getMilestoneId(),
            $file
        );

        if (!$evidence->hasChanges()) {
            return;
        }

        $this->unitOfWork->execute(function () use ($evidence, $actor_id) {
            $this->repository->update($evidence);

            $this->repository->updateMilestoneLink($evidence);

            $changes = $evidence->getChanges();

            if (isset($changes['milestone_id'])) {
                $changes['milestone_code'] = [
                    'old' => $this->milestoneReader->getCodeById($changes['milestone_id']['old']),
                    'new' => $this->milestoneReader->getCodeById($changes['milestone_id']['new'])
                ];
            }

            $this->eventDispatcher->dispatch(new EvidenceUpdated(
                $evidence->getId()->value(),
                $changes,
                $actor_id
            ));
        });
    }
}