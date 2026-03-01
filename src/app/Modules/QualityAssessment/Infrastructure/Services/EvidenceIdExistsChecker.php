<?php

namespace App\Modules\QualityAssessment\Infrastructure\Services;

use App\Modules\QualityAssessment\Domain\Services\EvidenceIdExistsCheckerInterface;
use App\Modules\QualityAssessment\Infrastructure\Models\Evidence;

final class EvidenceIdExistsChecker implements EvidenceIdExistsCheckerInterface
{
    public function check(string $id): bool
    {
        return Evidence::query()
                ->where('id', $id)
                ->exists();
    }
}