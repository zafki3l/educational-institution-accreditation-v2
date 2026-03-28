<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers\Milestone;

use App\Modules\QualityAssessment\Application\UseCases\Milestone\DeleteMilestoneUseCase;
use App\Modules\QualityAssessment\Presentation\Controllers\QualityAssessmentController;
use App\Shared\Security\Session\AuthSession;
use App\Shared\Web\Responses\JsonResponse;

final class DeleteMilestoneController extends QualityAssessmentController
{
    public function __construct(private DeleteMilestoneUseCase $deleteMilestoneUseCase) {}

    public function destroy(int $id)
    {
        $this->deleteMilestoneUseCase->execute($id, AuthSession::getUserId());

        return new JsonResponse([]);
    }
}