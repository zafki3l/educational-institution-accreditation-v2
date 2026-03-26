<?php

namespace App\Modules\QualityAssessment\Infrastructure\Readers;

use App\Modules\QualityAssessment\Application\Readers\CriteriaReaderInterface;
use App\Modules\QualityAssessment\Infrastructure\Models\Criteria;

class CriteriaReader implements CriteriaReaderInterface
{
    public function count(): int
    {
        return Criteria::count();
    }
}