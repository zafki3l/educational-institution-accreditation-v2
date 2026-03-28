<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers\Criteria;

use App\Modules\QualityAssessment\Application\UseCases\Criteria\DeleteCriteriaUseCase;
use App\Modules\QualityAssessment\Presentation\Controllers\QualityAssessmentController;
use App\Shared\Security\Session\AuthSession;

final class DeleteCriteriaController extends QualityAssessmentController
{
    public function __construct(private DeleteCriteriaUseCase $deleteCriteriaUseCase) {}

    public function destroy(string $id): void
    {
        $this->deleteCriteriaUseCase->execute($id, AuthSession::getUserId());

        $this->redirect('/criterias');
    }
}