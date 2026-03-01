<?php

namespace App\Modules\QualityAssessment\Domain\Services;

interface EvidenceIdExistsCheckerInterface
{
    public function check(string $id): bool;
}