<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers\MilestoneEvidence;

use App\Modules\QualityAssessment\Infrastructure\Models\Evidence;
use App\Modules\QualityAssessment\Presentation\Controllers\QualityAssessmentController;
use App\Shared\Response\JsonResponse;

final class IndexMilestoneEvidenceController extends QualityAssessmentController
{
    public function index(string $id): JsonResponse
    {
        $evidence = Evidence::with('allMilestones.criteria')->findOrFail($id);

        $grouped = $evidence->allMilestones
            ->groupBy(fn($m) => $m->criteria->id)
            ->map(function ($milestones, $criteriaId) {
                $criteria = $milestones->first()->criteria;

                return [
                    'id' => $criteria->id,
                    'standard_id' => $criteria->standard_id,
                    'name' => $criteria->name,
                    'milestones' => $milestones->map(fn($m) => [
                        'id' => $m->id,
                        'criteria_id' => $m->criteria_id,
                        'code' => $m->code,
                        'order' => $m->order,
                        'name' => $m->name,
                    ])->values()
                ];
            })
            ->values();

        return new JsonResponse([
            'allCriterias' => $grouped
        ]);
    }
}