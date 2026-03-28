<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers\Standard;

use App\Modules\QualityAssessment\Application\UseCases\Standard\CreateStandardUseCase;
use App\Modules\QualityAssessment\Presentation\Controllers\QualityAssessmentController;
use App\Modules\QualityAssessment\Presentation\Requests\Standard\CreateStandardRequest;
use App\Shared\Domain\Exception\DomainException;
use App\Shared\Response\JsonResponse;
use App\Shared\SessionManager\AuthSession;

final class CreateStandardController extends QualityAssessmentController
{
    public function __construct(private CreateStandardUseCase $createStandardUseCase) {}

    public function store(CreateStandardRequest $request): JsonResponse
    {
        try {
            $this->createStandardUseCase->execute($request, AuthSession::getUserId());

            return new JsonResponse([]);

        } catch (DomainException $e) {

            return new JsonResponse([
                'errors' => [$e->getMessage()]
            ], 422);
        }
    }
}