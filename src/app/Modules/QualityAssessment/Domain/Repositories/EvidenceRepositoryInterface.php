<?php

namespace App\Modules\QualityAssessment\Domain\Repositories;

use App\Modules\QualityAssessment\Domain\Entities\Evidence as EntitiesEvidence;

interface EvidenceRepositoryInterface
{
    public function create(EntitiesEvidence $entitiesEvidence): void;

    public function delete(string $id): string;

    public function update(EntitiesEvidence $entitiesEvidence): string;

    public function attachMilestone(string $evidence_id, string $milestone_id): void;
}