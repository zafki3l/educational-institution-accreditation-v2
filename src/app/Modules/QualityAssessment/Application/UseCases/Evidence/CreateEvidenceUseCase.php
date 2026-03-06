<?php

namespace App\Modules\QualityAssessment\Application\UseCases\Evidence;

use App\Modules\QualityAssessment\Application\Requests\Evidence\CreateEvidenceRequestInterface;
use App\Modules\QualityAssessment\Domain\Entities\Evidence;
use App\Modules\QualityAssessment\Domain\Exception\Evidence\EvidenceEmptyIssuedDateException;
use App\Modules\QualityAssessment\Domain\Exception\Evidence\EvidenceIdExistsException;
use App\Modules\QualityAssessment\Domain\Repositories\EvidenceRepositoryInterface;
use App\Modules\QualityAssessment\Domain\Services\EvidenceFileUploaderInterface;
use App\Modules\QualityAssessment\Domain\Services\EvidenceIdExistsCheckerInterface;
use App\Modules\QualityAssessment\Domain\Services\EvidenceIssuedDateEmptyCheckerInterface;
use App\Modules\QualityAssessment\Domain\Services\EvidencePermissionCheckerInterface;
use App\Modules\QualityAssessment\Domain\ValueObjects\Evidence\EvidenceId;
use App\Shared\Logging\LoggerInterface;
use DateTimeImmutable;

final class CreateEvidenceUseCase
{
    public function __construct(
        private EvidenceRepositoryInterface $repository,
        private EvidenceFileUploaderInterface $evidenceFileUploader,
        private EvidenceIdExistsCheckerInterface $evidenceIdExistsChecker,
        private EvidenceIssuedDateEmptyCheckerInterface $evidenceIssuedDateEmptyChecker,
        private EvidencePermissionCheckerInterface $evidencePermissionChecker,
        private LoggerInterface $logger
    ) {}
    
    public function execute(CreateEvidenceRequestInterface $request, string $actor_id): void
    {
        $this->evidencePermissionChecker->check($request->getCriteriaId(), $actor_id);

        if ($this->evidenceIdExistsChecker->check($request->getId())) {
            throw new EvidenceIdExistsException();
        }

        if ($this->evidenceIssuedDateEmptyChecker->check($request->getIssuedDate())) {
            throw new EvidenceEmptyIssuedDateException();
        }

        $evidence = Evidence::create(
            EvidenceId::fromString($request->getId()),
            $request->getName(),
            $request->getDocumentNumber(),
            new DateTimeImmutable($request->getIssuedDate()),
            $request->getIssuingAuthority(),
            $request->getMilestoneId()
        );

        $isFileUploaded = $request->getFile()['error'] === UPLOAD_ERR_OK;
        if ($isFileUploaded) {
            $evidence->changeFileUrl($this->evidenceFileUploader->upload($request->getFile(), $request->getId()));
        }
        
        $this->repository->create($evidence);

        $this->writeLog($evidence, $request->getCriteriaId(), $actor_id);
    }

    private function writeLog(Evidence $evidence, string $criteria_id, string $actor_id): void
    {
        $this->logger->write(
            'info',
            'delete', 
            "Người dùng {$actor_id} đã thêm 1 minh chứng. Mã minh chứng: {$evidence->getId()->value()}", 
            $actor_id, 
            [
                'id' => $evidence->getId()->value(),
                'name' => $evidence->getName(),
                'document_number' => $evidence->getDocumentNumber(),
                'issued_date' => $evidence->getIssuedDate()->format('Y-m-d'),
                'issuing_authority' => $evidence->getIssuingAuthority(),
                'file_url' => $evidence->getFileUrl() ? $evidence->getFileUrl() : '',
                'milestone_id' => $evidence->getMilestoneId(),
                'criteria_id' => $criteria_id
            ]
        );
    }
}