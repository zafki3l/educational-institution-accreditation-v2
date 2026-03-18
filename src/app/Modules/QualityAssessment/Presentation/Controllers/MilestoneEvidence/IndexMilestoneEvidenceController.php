<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers\MilestoneEvidence;

use App\Modules\QualityAssessment\Infrastructure\Models\Evidence;
use App\Modules\QualityAssessment\Presentation\Controllers\QualityAssessmentController;
use App\Shared\Response\JsonResponse;

final class IndexMilestoneEvidenceController extends QualityAssessmentController
{
    public function index(string $id): JsonResponse
    {
        $evidence = Evidence::with([
            'milestone.criteria',
            'milestones.criteria'
        ])->findOrFail($id);

        $milestones = $this->buildMilestones($evidence);

        $grouped = $milestones
            ->groupBy(fn($m) => $m->criteria->id)
            ->map(fn($group) => $this->formatCriteria($group))
            ->values();

        return new JsonResponse([
            'allCriterias' => $grouped
        ]);
    }

    private function buildMilestones($evidence)
    {
        $list = $evidence->milestones->map(function ($m) use ($evidence) {
            $m->is_primary = $m->id === $evidence->milestone_id;
            return $m;
        });

        // ensure primary always exists
        if (
            $evidence->milestone &&
            !$list->contains('id', $evidence->milestone_id)
        ) {
            $pm = $evidence->milestone;
            $pm->is_primary = true;
            $list->push($pm);
        }

        return $list;
    }

    private function formatCriteria($milestones)
    {
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
    }
}