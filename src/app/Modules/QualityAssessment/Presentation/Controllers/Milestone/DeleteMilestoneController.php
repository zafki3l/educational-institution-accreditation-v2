<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers\Milestone;

use App\Modules\QualityAssessment\Application\UseCases\Milestone\DeleteMilestoneUseCase;
use App\Modules\QualityAssessment\Presentation\Controllers\QualityAssessmentController;
use App\Shared\Security\Session\AuthSession;
use App\Shared\Web\Responses\JsonResponse;

final class DeleteMilestoneController extends QualityAssessmentController
{
    public function __construct(
        private DeleteMilestoneUseCase $deleteMilestoneUseCase,
        private AuthSession $authSession
    ) {}

    public function destroy(int $id): JsonResponse
    {
        $this->deleteMilestoneUseCase->execute($id, $this->authSession->authUser()->user_id);

        return new JsonResponse([]);
    }
}