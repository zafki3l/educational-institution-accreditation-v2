<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers\Milestone;

use App\Modules\QualityAssessment\Application\UseCases\Milestone\CreateMilestoneUseCase;
use App\Modules\QualityAssessment\Presentation\Controllers\QualityAssessmentController;
use App\Modules\QualityAssessment\Presentation\Requests\Milestone\CreateMilestoneRequest;
use App\Shared\Domain\Exception\DomainException;
use App\Shared\Security\Session\AuthSession;
use App\Shared\Web\Responses\JsonResponse;

final class CreateMilestoneController extends QualityAssessmentController
{
    public function __construct(
        private CreateMilestoneUseCase $createMilestoneUseCase,
        private AuthSession $authSession
    ) {}

    public function store(CreateMilestoneRequest $request): JsonResponse
    {
        try {
            $milestone = $this->createMilestoneUseCase->execute($request, $this->authSession->authUser()->user_id);

            return new JsonResponse([
                'id' => $milestone->getId(),
                'criteria_id' => $milestone->getCriteriaId(),
                'code' => $milestone->getCode()->value(),
                'order' => $milestone->getOrder(),
                'name' => $milestone->getName()
            ]);
        } catch (DomainException $e) {
            return new JsonResponse([
                'errors' => [$e->getMessage()]
            ], 422);
        }
    }
}