<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers\MilestoneEvidence;

use App\Modules\QualityAssessment\Application\UseCases\MilestoneEvidence\DeleteMilestoneEvidenceUseCase;
use App\Modules\QualityAssessment\Presentation\Controllers\QualityAssessmentController;
use App\Modules\QualityAssessment\Presentation\Requests\MilestoneEvidence\DeleteMilestoneEvidenceRequest;
use App\Shared\Exception\DomainException;
use App\Shared\SessionManager\AuthSession;

final class DeleteMilestoneEvidenceController extends QualityAssessmentController
{
    public function __construct(private DeleteMilestoneEvidenceUseCase $deleteMilestoneEvidenceUseCase) {}

    public function destroy(DeleteMilestoneEvidenceRequest $request): void
    {
        try {
            $this->deleteMilestoneEvidenceUseCase->execute($request, AuthSession::getUserId());

            $this->redirect("/criterias/{$request->getCriteriaId()}/evidences");
        } catch (DomainException $e) {
            $_SESSION['errors'] = [$e->getMessage()];
            
            $this->redirect("/criterias/{$request->getCriteriaId()}/evidences");
        }
    }
}