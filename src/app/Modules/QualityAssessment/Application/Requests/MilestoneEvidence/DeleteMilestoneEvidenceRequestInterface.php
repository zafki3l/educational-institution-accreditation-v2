<?php

namespace App\Modules\QualityAssessment\Application\Requests\MilestoneEvidence;

interface DeleteMilestoneEvidenceRequestInterface
{
    public function getEvidenceId(): string;

    public function getCriteriaId(): string;
    
    public function getMilestoneId(): int;
}