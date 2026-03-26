<?php

namespace App\Modules\QualityAssessment\Infrastructure\Readers;

use App\Modules\QualityAssessment\Application\Readers\MilestoneReaderInterface;
use App\Modules\QualityAssessment\Infrastructure\Models\Milestone;

class MilestoneReader implements MilestoneReaderInterface
{
    public function count(): int
    {
        return Milestone::count();
    }
}