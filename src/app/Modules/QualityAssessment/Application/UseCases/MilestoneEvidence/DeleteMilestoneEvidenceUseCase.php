<?php

namespace App\Modules\QualityAssessment\Application\UseCases\MilestoneEvidence;

use App\Modules\QualityAssessment\Application\Requests\MilestoneEvidence\DeleteMilestoneEvidenceRequestInterface;
use App\Modules\QualityAssessment\Domain\Repositories\MilestoneEvidenceRepositoryInterface;
use App\Shared\Logging\LoggerInterface;

final class DeleteMilestoneEvidenceUseCase
{
    public function __construct(
        private MilestoneEvidenceRepositoryInterface $repository,
        private LoggerInterface $logger
    ) {}

    public function execute(DeleteMilestoneEvidenceRequestInterface $request, string $actor_id): void
    {
        $this->repository->delete($request->getEvidenceId(), $request->getMilestoneId());

        $this->writeLog($request, $actor_id);
    }

    private function writeLog(DeleteMilestoneEvidenceRequestInterface $request, string $actor_id): void
    {
        $this->logger->write(
            'info',
            'create', 
            "Người dùng {$actor_id} đã thêm 1 mốc đánh giá vào minh chứng {$request->getEvidenceId()}", 
            $actor_id, 
            [
                'evidence_id' => $request->getEvidenceId(),
                'criteria_id' => $request->getCriteriaId(),
                'milestone_id' => $request->getMilestoneId()
            ]
        );
    }
}