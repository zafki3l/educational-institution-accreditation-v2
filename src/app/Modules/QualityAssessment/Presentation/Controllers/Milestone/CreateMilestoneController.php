<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers\Milestone;

use App\Modules\QualityAssessment\Application\UseCases\Milestone\CreateMilestoneUseCase;
use App\Modules\QualityAssessment\Presentation\Controllers\QualityAssessmentController;
use App\Modules\QualityAssessment\Presentation\Requests\Milestone\CreateMilestoneRequest;
use App\Shared\Domain\Exception\DomainException;
use App\Shared\Response\JsonResponse;
use App\Shared\SessionManager\AuthSession;

final class CreateMilestoneController extends QualityAssessmentController
{
    public function __construct(private CreateMilestoneUseCase $createMilestoneUseCase) {}

    public function store(CreateMilestoneRequest $request)
    {
        try {
            $milestone = $this->createMilestoneUseCase->execute($request, AuthSession::getUserId());

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