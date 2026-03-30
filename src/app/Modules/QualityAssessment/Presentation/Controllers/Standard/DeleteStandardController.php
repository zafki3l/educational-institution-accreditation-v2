<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers\Standard;

use App\Modules\QualityAssessment\Application\UseCases\Standard\DeleteStandardUseCase;
use App\Modules\QualityAssessment\Presentation\Controllers\QualityAssessmentController;
use App\Shared\Security\Session\AuthSession;

final class DeleteStandardController extends QualityAssessmentController
{
    public function __construct(
        private DeleteStandardUseCase $deleteStandardUseCase,
        private AuthSession $authSession
    ) {}

    public function destroy(string $id)
    {
        $this->deleteStandardUseCase->execute($id, $this->authSession->authUser()->user_id);

        $this->redirect('/standards');
    }
}