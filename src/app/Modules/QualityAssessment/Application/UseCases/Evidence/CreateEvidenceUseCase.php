<?php

namespace App\Modules\QualityAssessment\Application\UseCases\Evidence;

use App\Modules\QualityAssessment\Application\Requests\Evidence\CreateEvidenceRequestInterface;
use App\Modules\QualityAssessment\Domain\Entities\Evidence;
use App\Modules\QualityAssessment\Domain\Repositories\EvidenceRepositoryInterface;
use App\Modules\QualityAssessment\Domain\Services\EvidenceFileUploaderInterface;
use App\Modules\QualityAssessment\Domain\ValueObjects\Evidence\EvidenceId;
use DateTimeImmutable;

final class CreateEvidenceUseCase
{
    public function __construct(
        private EvidenceRepositoryInterface $repository,
        private EvidenceFileUploaderInterface $evidenceFileUploader
    ) {}
    
    public function execute(CreateEvidenceRequestInterface $request)
    {
        $file_url = $this->evidenceFileUploader->upload($request->getFile(), $request->getId());

        $evidence = Evidence::create(
            EvidenceId::fromString($request->getId()),
            $request->getName(),
            $request->getDocumentNumber(),
            new DateTimeImmutable($request->getIssuedDate()),
            $request->getIssuingAuthority(),
            $file_url,
            $request->getMilestoneId()
        );

        $this->repository->create($evidence);
    }
}