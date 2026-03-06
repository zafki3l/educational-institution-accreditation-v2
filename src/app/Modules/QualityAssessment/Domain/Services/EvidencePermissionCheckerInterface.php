<?php

namespace App\Modules\QualityAssessment\Domain\Services;

interface EvidencePermissionCheckerInterface
{
    public function check(string $criteria_id, string $actor_id): void;
}