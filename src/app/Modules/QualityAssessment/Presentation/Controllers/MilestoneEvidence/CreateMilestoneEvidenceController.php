<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers\MilestoneEvidence;

use App\Modules\QualityAssessment\Application\UseCases\MilestoneEvidence\CreateMilestoneEvidenceUseCase;
use App\Modules\QualityAssessment\Presentation\Controllers\QualityAssessmentController;
use App\Modules\QualityAssessment\Presentation\Requests\MilestoneEvidence\CreateMilestoneEvidenceRequest;
use App\Shared\Exception\DomainException;
use App\Shared\SessionManager\AuthSession;

final class CreateMilestoneEvidenceController extends QualityAssessmentController
{
    public function __construct(private CreateMilestoneEvidenceUseCase $createMilestoneEvidenceUseCase) {}

    public function store(CreateMilestoneEvidenceRequest $request): void
    {
        try {
            $this->createMilestoneEvidenceUseCase->execute($request, AuthSession::getUserId());
        
            $this->redirect("/criterias/{$request->getCriteriaId()}/evidences");
        } catch (DomainException $e) {
            $_SESSION['errors'] = [$e->getMessage()];

            $this->redirect("/criterias/{$request->getCriteriaId()}/evidences");
        }
    }
}