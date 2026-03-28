<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers\Standard;

use App\Modules\QualityAssessment\Infrastructure\Models\Standard;
use App\Modules\QualityAssessment\Presentation\Controllers\QualityAssessmentController;
use App\Modules\QualityAssessment\Presentation\Requests\Standard\UpdateStandardRequest;
use App\Shared\Web\Responses\JsonResponse;

final class UpdateStandardController extends QualityAssessmentController
{
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
        $standard = Standard::findOrFail($request->getId());

        $standard->update([
            'id' => $request->getId(),
            'name' => $request->getName(),
            'department_id' => $request->getDepartmentId()
        ]);

        return new JsonResponse([]);
    }
}