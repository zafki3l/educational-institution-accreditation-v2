<?php

namespace App\Modules\QualityAssessment\Application\UseCases\MilestoneEvidence;

use App\Modules\QualityAssessment\Application\Requests\MilestoneEvidence\CreateMilestoneEvidenceRequestInterface;
use App\Modules\QualityAssessment\Domain\Entities\MilestoneEvidence;
use App\Modules\QualityAssessment\Domain\Repositories\MilestoneEvidenceRepositoryInterface;
use App\Modules\QualityAssessment\Domain\ValueObjects\Evidence\EvidenceId;
use App\Shared\Logging\LoggerInterface;
use App\Shared\Exception\DomainException; 

final class CreateMilestoneEvidenceUseCase
{
    public function __construct(
        private MilestoneEvidenceRepositoryInterface $repository,
        private LoggerInterface $logger
    ) {}

    public function execute(CreateMilestoneEvidenceRequestInterface $request, string $actor_id): void
    {
        $evidenceId = $request->getEvidenceId();
        $targetCriteriaId = $request->getCriteriaId();

        $primaryCriteriaId = $this->repository->getPrimaryCriteriaIdByEvidence($evidenceId);

        if ($primaryCriteriaId !== null && $primaryCriteriaId === $targetCriteriaId) {
            throw new DomainException('Không thể thêm mốc đánh giá vì tiêu chí này đã chứa mốc đánh giá chính của minh chứng.');
        }

        $milestoneEvidence = MilestoneEvidence::create(
            EvidenceId::fromString($evidenceId),
            $request->getMilestoneId()
        );

        $this->repository->create($milestoneEvidence);
        
        $this->writeLog($request, $actor_id);
    }

    private function writeLog(CreateMilestoneEvidenceRequestInterface $request, string $actor_id): void
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