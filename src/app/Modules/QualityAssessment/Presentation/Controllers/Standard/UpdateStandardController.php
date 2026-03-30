<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers\Standard;

use App\Modules\QualityAssessment\Application\UseCases\Standard\UpdateStandardUseCase;
use App\Modules\QualityAssessment\Infrastructure\Models\Standard;
use App\Modules\QualityAssessment\Presentation\Controllers\QualityAssessmentController;
use App\Modules\QualityAssessment\Presentation\Requests\Standard\UpdateStandardRequest;
use App\Shared\Security\Session\AuthSession;
use App\Shared\Web\Responses\JsonResponse;

final class UpdateStandardController extends QualityAssessmentController
{
    public function __construct(
        private UpdateStandardUseCase $updateStandardUseCase,
        private AuthSession $authSession
    ) {}

    public function edit(string $id): JsonResponse
    {
        $standard = Standard::findOrFail($id);

        return new JsonResponse([
            'id' => $standard->id,
            'name' => $standard->name, 
            'department_id' => $standard->department_id
        ]);
    }

    public function update(UpdateStandardRequest $request): JsonResponse
    {
        $this->updateStandardUseCase->execute($request, $this->authSession->authUser()->user_id);

        return new JsonResponse([]);
    }
}