<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers\Evidence;

use App\Modules\QualityAssessment\Infrastructure\Models\Evidence;
use App\Modules\QualityAssessment\Infrastructure\Models\Milestone;
use App\Modules\QualityAssessment\Infrastructure\Models\OtherMilestone;
use App\Modules\QualityAssessment\Presentation\Controllers\QualityAssessmentController;
use App\Shared\Response\JsonResponse;

final class EvidenceMilestoneController extends QualityAssessmentController
{
    public function getMilestones(string $id)
    {
        $evidence = Evidence::with(['milestone.criteria'])->findOrFail($id);

        $milestones = [];

        if ($evidence->milestone) {
            $milestones[] = [
                'id'             => 'primary_' . $evidence->milestone->id,
                'criteria_id'    => $evidence->milestone->criteria_id ?? '',
                'criteria_name'  => $evidence->milestone->criteria->name ?? '',
                'milestone_name' => $evidence->milestone->name,
                'is_primary'     => true,
            ];
        }

        $extras = OtherMilestone::with(['milestone.criteria'])
            ->where('evidence_id', $id)
            ->get();

        foreach ($extras as $row) {
            $milestones[] = [
                'id'             => $row->id,
                'criteria_id'    => $row->milestone->criteria_id ?? '',
                'criteria_name'  => $row->milestone->criteria->name ?? '',
                'milestone_name' => $row->milestone->name ?? '',
                'is_primary'     => false,
            ];
        }

        return new JsonResponse(['milestones' => $milestones]);
    }

    public function addMilestone(string $id)
    {
        Evidence::findOrFail($id);

        $milestoneId = $_POST['milestone_id'] ?? null;

        if (!$milestoneId) {
            return new JsonResponse(['error' => 'milestone_id is required'], 422);
        }

        Milestone::findOrFail($milestoneId);

        $existing = OtherMilestone::where('evidence_id', $id)
            ->where('milestone_id', $milestoneId)
            ->first();

        if (!$existing) {
            OtherMilestone::create([
                'evidence_id'  => $id,
                'milestone_id' => $milestoneId,
            ]);
        }

        return $this->getMilestones($id);
    }

    public function removeMilestone(string $id, string $mapping_id)
    {
        $row = OtherMilestone::where('id', $mapping_id)
            ->where('evidence_id', $id)
            ->firstOrFail();

        $row->delete();

        return new JsonResponse(['success' => true]);
    }
}
