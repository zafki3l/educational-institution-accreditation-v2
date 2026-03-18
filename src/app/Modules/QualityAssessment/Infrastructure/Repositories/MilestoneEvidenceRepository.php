<?php

namespace App\Modules\QualityAssessment\Infrastructure\Repositories;

use App\Modules\QualityAssessment\Domain\Entities\MilestoneEvidence as EntitiesMilestoneEvidence;
use App\Modules\QualityAssessment\Domain\Repositories\MilestoneEvidenceRepositoryInterface;
use App\Modules\QualityAssessment\Infrastructure\Models\Evidence;
use App\Modules\QualityAssessment\Infrastructure\Models\MilestoneEvidence as ModelsMilestoneEvidence;
use App\Shared\Exception\DomainException;


class MilestoneEvidenceRepository implements MilestoneEvidenceRepositoryInterface
{
    public function create(EntitiesMilestoneEvidence $entitiesMilestoneEvidence): void
    {
        ModelsMilestoneEvidence::create([
            'evidence_id' => $entitiesMilestoneEvidence->getEvidenceId()->value(),
            'milestone_id' => $entitiesMilestoneEvidence->getMilestoneId()
        ]);
    }

    public function delete(string $evidence_id, string $milestone_id): void
    {
        $isPrimary = Evidence::where('id', $evidence_id)
                            ->where('milestone_id', $milestone_id)
                            ->exists();

        if ($isPrimary) {
            throw new DomainException("Không thể xóa liên kết với Milestone chính!");
        }

        ModelsMilestoneEvidence::where('evidence_id', $evidence_id)
                                ->where('milestone_id', $milestone_id)
                                ->delete();
    }

    public function hasMilestoneInCriteria(string $evidenceId, string $criteriaId): bool
    {
        $primaryCriteriaId = Evidence::query()
            ->join('milestones', 'evidences.milestone_id', '=', 'milestones.id')
            ->where('evidences.id', $evidenceId)
            ->value('milestones.criteria_id'); 
        if ((string) $primaryCriteriaId === (string) $criteriaId) {
            return true;
        }

        $hasSecondary = ModelsMilestoneEvidence::query()
            ->join('milestones', 'milestones_evidences.milestone_id', '=', 'milestones.id')
            ->where('milestones_evidences.evidence_id', $evidenceId)
            ->where('milestones.criteria_id', $criteriaId)
            ->exists();

        return $hasSecondary;
    }
}