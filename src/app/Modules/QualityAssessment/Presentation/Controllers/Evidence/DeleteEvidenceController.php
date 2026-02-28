<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers\Evidence;

use App\Modules\QualityAssessment\Application\UseCases\Evidence\DeleteEvidenceUseCase;
use App\Modules\QualityAssessment\Presentation\Controllers\QualityAssessmentController;
use App\Shared\SessionManager\AuthSession;

final class DeleteEvidenceController extends QualityAssessmentController
{
    public function __construct(private DeleteEvidenceUseCase $deleteEvidenceUseCase) {}

    public function destroy(string $id): void
    {
        $criteria_id = $this->deleteEvidenceUseCase->execute($id, AuthSession::getUserId());
        
        $this->redirect("/criterias/{$criteria_id}/evidences"); 
    }
}