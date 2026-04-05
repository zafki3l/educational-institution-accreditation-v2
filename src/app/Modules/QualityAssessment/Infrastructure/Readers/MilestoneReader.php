<?php

namespace App\Modules\QualityAssessment\Infrastructure\Readers;

use App\Modules\QualityAssessment\Application\Readers\MilestoneReaderInterface;
use App\Modules\QualityAssessment\Infrastructure\Models\Criteria;
use App\Modules\QualityAssessment\Infrastructure\Models\Milestone;

class MilestoneReader implements MilestoneReaderInterface
{
    public function getByCriteriaId(string $criteria_id): array
    {
        return Criteria::with('milestones')
                        ->findOrFail($criteria_id)
                        ->toArray();
    }

    public function count(): int
    {
        return Milestone::count();
    }

    public function getCodeById(int $id): string
    {
        return Milestone::where('id', $id)->value('code');
    }
}