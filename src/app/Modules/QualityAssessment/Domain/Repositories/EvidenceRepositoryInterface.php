<?php

namespace App\Modules\QualityAssessment\Domain\Repositories;

use App\Modules\QualityAssessment\Domain\Entities\Evidence as EntitiesEvidence;

interface EvidenceRepositoryInterface
{
    public function create(EntitiesEvidence $entitiesEvidence): void;

    public function findOrFail(string $id): EntitiesEvidence;

    public function delete(string $id): void;

    public function update(EntitiesEvidence $entitiesEvidence): void;

    public function attachMilestone(string $evidence_id, string $milestone_id): void;

    public function updateMilestoneLink(EntitiesEvidence $entitiesEvidence): void;
}