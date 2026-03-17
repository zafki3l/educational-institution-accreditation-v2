<?php

namespace App\Modules\QualityAssessment\Presentation\Requests\MilestoneEvidence;

use App\Modules\QualityAssessment\Application\Requests\MilestoneEvidence\DeleteMilestoneEvidenceRequestInterface;

final class DeleteMilestoneEvidenceRequest implements DeleteMilestoneEvidenceRequestInterface
{
    private string $evidence_id;
    private string $criteria_id;
    private int $milestone_id;

    public function __construct()
    {
        $this->evidence_id = $_POST['evidence_id'];
        $this->criteria_id = $_POST['criteria_id'];
        $this->milestone_id = (int) $_POST['milestone_id'];
    }

    public function getEvidenceId(): string
    {
        return $this->evidence_id;
    }

    public function getCriteriaId(): string
    {
        return $this->criteria_id;
    }

    public function getMilestoneId(): int
    {
        return $this->milestone_id;
    }
}
