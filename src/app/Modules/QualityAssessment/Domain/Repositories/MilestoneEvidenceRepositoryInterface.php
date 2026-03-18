<?php

namespace App\Modules\QualityAssessment\Domain\Repositories;

use App\Modules\QualityAssessment\Domain\Entities\MilestoneEvidence as EntitiesMilestoneEvidence;

interface MilestoneEvidenceRepositoryInterface
{
    public function create(EntitiesMilestoneEvidence $entitiesMilestoneEvidence): void;

    public function delete(string $evidence_id, string $milestone_id): void;

    public function getPrimaryCriteriaIdByEvidence(string $evidenceId): ?string;
}