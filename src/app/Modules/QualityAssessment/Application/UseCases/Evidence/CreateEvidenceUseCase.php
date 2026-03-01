<?php

namespace App\Modules\QualityAssessment\Application\UseCases\Evidence;

use App\Modules\QualityAssessment\Application\Requests\Evidence\CreateEvidenceRequestInterface;
use App\Modules\QualityAssessment\Domain\Entities\Evidence;
use App\Modules\QualityAssessment\Domain\Exception\Evidence\EvidenceIdExistsException;
use App\Modules\QualityAssessment\Domain\Repositories\EvidenceRepositoryInterface;
use App\Modules\QualityAssessment\Domain\Services\EvidenceFileUploaderInterface;
use App\Modules\QualityAssessment\Domain\Services\EvidenceIdExistsCheckerInterface;
use App\Modules\QualityAssessment\Domain\ValueObjects\Evidence\EvidenceId;
use DateTimeImmutable;

final class CreateEvidenceUseCase
{
    public function __construct(
        private EvidenceRepositoryInterface $repository,
        private EvidenceFileUploaderInterface $evidenceFileUploader,
        private EvidenceIdExistsCheckerInterface $evidenceIdExistsChecker
    ) {}
    
    public function execute(CreateEvidenceRequestInterface $request)
    {
        if ($this->evidenceIdExistsChecker->check($request->getId())) {
            throw new EvidenceIdExistsException();
        }

        $evidence = Evidence::create(
            EvidenceId::fromString($request->getId()),
            $request->getName(),
            $request->getDocumentNumber(),
            new DateTimeImmutable($request->getIssuedDate()),
            $request->getIssuingAuthority(),
            $request->getMilestoneId()
        );

        if ($request->getFile()['error'] === UPLOAD_ERR_OK) {
            $evidence->changeFileUrl($this->evidenceFileUploader->upload($request->getFile(), $request->getId()));
        }
        
        $this->repository->create($evidence);
    }
}