<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers\MilestoneEvidence;

use App\Modules\QualityAssessment\Infrastructure\Models\Evidence;
use App\Modules\QualityAssessment\Presentation\Controllers\QualityAssessmentController;
use App\Shared\Response\JsonResponse;

final class IndexMilestoneEvidenceController extends QualityAssessmentController
{
    public function index(string $id): JsonResponse
    {
        $evidence = Evidence::with('allMilestones.criteria')->find($id);

        $allCriterias = $evidence->allMilestones->pluck('criteria')->unique('id');

        return new JsonResponse([
            'allCriterias' => $allCriterias
        ]);
    }
}