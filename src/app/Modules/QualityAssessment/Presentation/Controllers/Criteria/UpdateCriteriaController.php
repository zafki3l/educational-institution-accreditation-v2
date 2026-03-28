<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers\Criteria;

use App\Modules\QualityAssessment\Application\UseCases\Criteria\UpdateCriteriaUseCase;
use App\Modules\QualityAssessment\Infrastructure\Models\Criteria;
use App\Modules\QualityAssessment\Presentation\Controllers\QualityAssessmentController;
use App\Modules\QualityAssessment\Presentation\Requests\Criteria\UpdateCriteriaRequest;
use App\Shared\Domain\Exception\DomainException;
use App\Shared\Response\JsonResponse;
use App\Shared\SessionManager\AuthSession;

final class UpdateCriteriaController extends QualityAssessmentController
{
    public function __construct(private UpdateCriteriaUseCase $updateCriteriaUseCase) {}

    public function edit(string $id): JsonResponse
    {
        $criterias = Criteria::findOrFail($id);

        return new JsonResponse([
            'id' => $criterias->id,
            'standard_id' => $criterias->standard_id,
            'name' => $criterias->name
        ]);
    }

    public function update(UpdateCriteriaRequest $request): JsonResponse
    {
        try {
            $this->updateCriteriaUseCase->execute($request, AuthSession::getUserId());
            
            return new JsonResponse([]);
        } catch (DomainException $e) {
            return new JsonResponse([
                'errors' => [$e->getMessage()],
            ], 422);
        }
    }
}