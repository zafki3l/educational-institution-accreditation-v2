<?php

namespace App\Modules\QualityAssessment\Domain\Services;

interface EvidenceIssuedDateEmptyCheckerInterface
{
    public function check(string $issued_date): bool;
}