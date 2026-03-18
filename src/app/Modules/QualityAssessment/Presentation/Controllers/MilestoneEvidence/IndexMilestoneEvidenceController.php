<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers\MilestoneEvidence;

use App\Modules\QualityAssessment\Infrastructure\Models\Evidence;
use App\Modules\QualityAssessment\Presentation\Controllers\QualityAssessmentController;
use App\Shared\Response\JsonResponse;

final class IndexMilestoneEvidenceController extends QualityAssessmentController
{
    public function index(string $id): JsonResponse
    {
        $evidence = Evidence::with(['milestone.criteria', 'allMilestones.criteria'])->findOrFail($id);

        $milestonesList = collect();
        if ($evidence->milestone) {
            $pm = $evidence->milestone;
            $pm->is_primary = true;
            $milestonesList->push($pm);
        }
        foreach ($evidence->allMilestones as $am) {
            if ($evidence->milestone_id === $am->id) {
                continue;
            }
            $am->is_primary = false;
            $milestonesList->push($am);
        }

        $grouped = $milestonesList
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
                        'is_primary' => $m->is_primary ?? false
                    ])->values()
                ];
            })
            ->values();

        return new JsonResponse([
            'allCriterias' => $grouped
        ]);
    }
}