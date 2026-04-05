<?php

namespace App\Modules\QualityAssessment\Application\UseCases\Evidence;

use App\Modules\QualityAssessment\Application\Readers\MilestoneReaderInterface;
use App\Modules\QualityAssessment\Application\Requests\Evidence\CreateEvidenceRequestInterface;
use App\Modules\QualityAssessment\Domain\Entities\Evidence;
use App\Modules\QualityAssessment\Domain\Events\Evidence\EvidenceCreated;
use App\Modules\QualityAssessment\Domain\Exception\Criteria\CriteriaEmptyIdException;
use App\Modules\QualityAssessment\Domain\Exception\Evidence\EvidenceIdExistsException;
use App\Modules\QualityAssessment\Domain\Exception\Evidence\EvidencePermissionAccessDeniedException;
use App\Modules\QualityAssessment\Domain\Repositories\EvidenceRepositoryInterface;
use App\Modules\QualityAssessment\Domain\Services\EvidenceFileUploaderInterface;
use App\Modules\QualityAssessment\Domain\Services\EvidenceIdExistsCheckerInterface;
use App\Modules\QualityAssessment\Domain\Services\EvidencePermissionCheckerInterface;
use App\Modules\QualityAssessment\Domain\ValueObjects\Evidence\EvidenceId;
use App\Shared\Contracts\Events\EventDispatcherInterface;
use App\Shared\Contracts\UnitOfWork\UnitOfWorkInterface;
use DateTimeImmutable;

final class CreateEvidenceUseCase
{
    public function __construct(
        private EvidenceRepositoryInterface $repository,
        private EvidenceFileUploaderInterface $evidenceFileUploader,
        private EvidenceIdExistsCheckerInterface $evidenceIdExistsChecker,
        private EvidencePermissionCheckerInterface $evidencePermissionChecker,
        private MilestoneReaderInterface $milestoneReader,
        private EventDispatcherInterface $eventDispatcher,
        private UnitOfWorkInterface $unitOfWork
    ) {}
    
    public function execute(CreateEvidenceRequestInterface $request, string $actor_id): void
    {
        if ($request->getCriteriaId() === '') {
            throw new CriteriaEmptyIdException();
        }
        
        if (!$this->evidencePermissionChecker->check($request->getCriteriaId(), $actor_id)) {
            throw new EvidencePermissionAccessDeniedException();
        }

        if ($this->evidenceIdExistsChecker->check($request->getId())) {
            throw new EvidenceIdExistsException();
        }

        $issuedDate = $request->getIssuedDate()
            ? new DateTimeImmutable($request->getIssuedDate())
            : null;

        $file = $request->getFile();

        $evidence = Evidence::create(
            EvidenceId::fromString($request->getId()),
            $request->getName(),
            $request->getDocumentNumber() ?: null,
            $issuedDate,
            $request->getIssuingAuthority(),
            $request->getMilestoneId()
        );

        $milestone_code = $this->milestoneReader->getCodeById($evidence->getMilestoneId());

        $this->unitOfWork->execute(function () use ($evidence, $file, $actor_id, $milestone_code) {
            if ($file['error'] === UPLOAD_ERR_OK) {
                $evidence->changeFileUrl($this->evidenceFileUploader->upload($file, $evidence->getId()->value()));
            }
            
            $this->repository->create($evidence);

            $this->repository->attachMilestone($evidence->getId()->value(), $evidence->getMilestoneId());
            
            $this->eventDispatcher->dispatch(new EvidenceCreated(
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