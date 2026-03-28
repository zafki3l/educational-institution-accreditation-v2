<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers\Criteria;

use App\Modules\QualityAssessment\Application\UseCases\Criteria\CreateCriteriaUseCase;
use App\Modules\QualityAssessment\Presentation\Controllers\QualityAssessmentController;
use App\Modules\QualityAssessment\Presentation\Requests\Criteria\CreateCriteriaRequest;
use App\Shared\Domain\Exception\DomainException;
use App\Shared\Response\JsonResponse;
use App\Shared\SessionManager\AuthSession;

final class CreateCriteriaController extends QualityAssessmentController
{
    public function __construct(
        private CreateCriteriaUseCase $createCriteriaUseCase
    ) {}

    public function store(CreateCriteriaRequest $request): JsonResponse
    {
        try {
            $this->createCriteriaUseCase->execute($request, AuthSession::getUserId());

            return new JsonResponse([]);
        } catch (DomainException $e) {
            return new JsonResponse([
                'errors' => [$e->getMessage()]
            ], 422);
        }
    }
}