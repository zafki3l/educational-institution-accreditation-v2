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
}