<?php

namespace App\Modules\QualityAssessment\Application\UseCases\Evidence;

use App\Modules\QualityAssessment\Application\Requests\Evidence\UpdateEvidenceRequestInterface;
use App\Modules\QualityAssessment\Domain\Entities\Evidence;
use App\Modules\QualityAssessment\Domain\Repositories\EvidenceRepositoryInterface;
use App\Modules\QualityAssessment\Domain\Services\EvidenceFileUploaderInterface;
use App\Modules\QualityAssessment\Domain\ValueObjects\Evidence\EvidenceId;
use App\Shared\Logging\LoggerInterface;
use DateTimeImmutable;

final class UpdateEvidenceUseCase
{
    public function __construct(
        private EvidenceRepositoryInterface $repository,
        private EvidenceFileUploaderInterface $evidenceFileUploader,
        private LoggerInterface $logger
    ) {}

    public function execute(UpdateEvidenceRequestInterface $request, string $actor_id): string
    {
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

        $criteria_id = $this->repository->update($evidence);

        $this->writeLog($evidence, $criteria_id, $actor_id);

        return $criteria_id;
    }

    private function writeLog(Evidence $evidence, string $criteria_id, string $actor_id): void
    {
        $this->logger->write(
            'info',
            'delete', 
            "Người dùng {$actor_id} đã cập nhật 1 minh chứng. Mã minh chứng: {$evidence->getId()->value()}", 
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