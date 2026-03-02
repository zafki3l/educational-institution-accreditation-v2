<?php

namespace App\Modules\QualityAssessment\Infrastructure\Services;

use App\Modules\QualityAssessment\Domain\Services\EvidenceIssuedDateEmptyCheckerInterface;

final class EvidenceIssuedDateEmptyChecker implements EvidenceIssuedDateEmptyCheckerInterface
{
    public function check(string $issued_date): bool
    {
        return $issued_date === '';
    }
}