<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers\Evidence;

use App\Modules\QualityAssessment\Application\UseCases\Evidence\DeleteEvidenceUseCase;
use App\Modules\QualityAssessment\Presentation\Controllers\QualityAssessmentController;
use App\Shared\Security\Session\AuthSession;

final class DeleteEvidenceController extends QualityAssessmentController
{
    public function __construct(
        private DeleteEvidenceUseCase $deleteEvidenceUseCase,
        private AuthSession $authSession
    ) {}

    public function destroy(string $criteria_id, string $id): void
    {
        $this->deleteEvidenceUseCase->execute($criteria_id, $id, $this->authSession->authUser()->user_id);
        
        $this->redirect("/criterias/{$criteria_id}/evidences?success=deleted"); 
    }
}