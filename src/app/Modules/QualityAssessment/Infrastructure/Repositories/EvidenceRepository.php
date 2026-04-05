<?php

namespace App\Modules\QualityAssessment\Infrastructure\Repositories;

use App\Modules\QualityAssessment\Domain\Entities\Evidence as EntitiesEvidence;
use App\Modules\QualityAssessment\Domain\Repositories\EvidenceRepositoryInterface;
use App\Modules\QualityAssessment\Domain\ValueObjects\Evidence\EvidenceId;
use App\Modules\QualityAssessment\Infrastructure\Models\Evidence as ModelsEvidence;
use App\Modules\QualityAssessment\Infrastructure\Models\MilestoneEvidence;
use DateTimeImmutable;

class EvidenceRepository implements EvidenceRepositoryInterface
{
    public function create(EntitiesEvidence $entitiesEvidence): void
    {
        ModelsEvidence::create([
            'id' => $entitiesEvidence->getId()->value(),
            'name' => $entitiesEvidence->getName(),
            'milestone_id' => $entitiesEvidence->getMilestoneId(),
            'document_number' => $entitiesEvidence->getDocumentNumber() ?: null,
            'issued_date' => $entitiesEvidence->getIssuedDate()?->format('Y-m-d'),
            'issuing_authority' => $entitiesEvidence->getIssuingAuthority(),
            'file_url' => $entitiesEvidence->getFileUrl()
        ]);
    }

    public function findOrFail(string $id): EntitiesEvidence
    {
        $modelsEvidence = ModelsEvidence::findOrFail($id);

        $entitiesEvidence = EntitiesEvidence::create(
            EvidenceId::fromString($modelsEvidence->id),
            $modelsEvidence->name,
            $modelsEvidence->document_number ? $modelsEvidence->document_number : null,
            $modelsEvidence->issued_date ? new DateTimeImmutable($modelsEvidence->issued_date) : null,
            $modelsEvidence->issuing_authority,
            $modelsEvidence->milestone_id
        );

        if (!empty($modelsEvidence->file_url)) {
            $entitiesEvidence->changeFileUrl($modelsEvidence->file_url);
        }

        return $entitiesEvidence;
    }

    public function delete(string $id): void
    {
        MilestoneEvidence::where('evidence_id', $id)->delete();
        
        ModelsEvidence::with('milestone.criteria')->findOrFail($id)->delete();
    }

    public function update(EntitiesEvidence $entitiesEvidence): void
    {
        $changes = $entitiesEvidence->getChanges();
        $data = [];

        foreach ($changes as $key => $value) {
            if ($key === 'issued_date' && $value['new'] instanceof DateTimeImmutable) {
                $data[$key] = $value['new']->format('Y-m-d');
            } else {
                $data[$key] = $value['new'];
            }
        }

        ModelsEvidence::with('milestone.criteria')
            ->findOrFail($entitiesEvidence->getId()->value())
            ->update($data);
    }

    public function attachMilestone(string $evidence_id, string $milestone_id): void
    {
        MilestoneEvidence::create([
            'evidence_id' => $evidence_id,
            'milestone_id' => $milestone_id
        ]);
    }

    public function updateMilestoneLink(EntitiesEvidence $entitiesEvidence): void
    {
        if (isset($entitiesEvidence->getChanges()['milestone_id'])) {
            MilestoneEvidence::where('evidence_id', $entitiesEvidence->getId()->value())
                            ->update(['milestone_id' => $entitiesEvidence->getMilestoneId()]);
        }
    }
}