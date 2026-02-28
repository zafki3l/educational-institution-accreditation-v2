<?php

namespace App\Modules\QualityAssessment\Infrastructure\Repositories;

use App\Modules\QualityAssessment\Domain\Entities\Evidence as EntitiesEvidence;
use App\Modules\QualityAssessment\Domain\Repositories\EvidenceRepositoryInterface;
use App\Modules\QualityAssessment\Infrastructure\Models\Evidence as ModelsEvidence;

class EvidenceRepository implements EvidenceRepositoryInterface
{
    public function create(EntitiesEvidence $entitiesEvidence): void
    {
        ModelsEvidence::create([
            'id' => $entitiesEvidence->getId()->value(),
            'name' => $entitiesEvidence->getName(),
            'milestone_id' => $entitiesEvidence->getMilestoneId(),
            'document_number' => $entitiesEvidence->getDocumentNumber(),
            'issued_date' => $entitiesEvidence->getIssuedDate()->format('Y-m-d'),
            'issuing_authority' => $entitiesEvidence->getIssuingAuthority(),
            'file_url' => $entitiesEvidence->getFileUrl()
        ]);
    }

    public function delete(string $id): string
    {
        $evidence = ModelsEvidence::with('milestone')->select('id', 'milestone_id', 'name')->findOrFail($id);

        $criteria_id = $evidence->milestone->criteria_id;

        $evidence->delete();

        return $criteria_id;
    }

    public function update(EntitiesEvidence $entitiesEvidence): string
    {
        $evidence = ModelsEvidence::with(['milestone.criteria.standard'])->findOrFail($entitiesEvidence->getId()->value());

        $data = [
            'name' => $entitiesEvidence->getName(),
            'document_number' => $entitiesEvidence->getDocumentNumber(),
            'issued_date' => $entitiesEvidence->getIssuedDate(),
            'issuing_authority' => $entitiesEvidence->getIssuingAuthority()
        ];

        if ($entitiesEvidence !== null || $entitiesEvidence !== '') {
            $data['file_url'] = $entitiesEvidence->getFileUrl();
        }

        $evidence->update($data);

        $evidence->refresh();   

        return $evidence->milestone->criteria->id;
    }
}