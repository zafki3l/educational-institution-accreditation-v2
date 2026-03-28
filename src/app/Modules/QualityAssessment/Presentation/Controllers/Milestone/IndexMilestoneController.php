<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers\Milestone;

use App\Modules\QualityAssessment\Infrastructure\Models\Criteria;
use App\Modules\QualityAssessment\Presentation\Controllers\QualityAssessmentController;
use App\Shared\Web\Responses\JsonResponse;

final class IndexMilestoneController extends QualityAssessmentController
{
    public function index(string $criteria_id): JsonResponse
    {
        $criteria = Criteria::with('milestones')->findOrFail($criteria_id);

        return new JsonResponse(['criteria' => $criteria]);
    }
}