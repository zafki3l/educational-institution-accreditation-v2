<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers\MilestoneEvidence;

use App\Modules\QualityAssessment\Application\UseCases\MilestoneEvidence\DeleteMilestoneEvidenceUseCase;
use App\Modules\QualityAssessment\Presentation\Controllers\QualityAssessmentController;
use App\Modules\QualityAssessment\Presentation\Requests\MilestoneEvidence\DeleteMilestoneEvidenceRequest;
use App\Shared\Domain\Exception\DomainException;
use App\Shared\SessionManager\AuthSession;
use App\Shared\Web\Responses\JsonResponse;

final class DeleteMilestoneEvidenceController extends QualityAssessmentController
{
    public function __construct(private DeleteMilestoneEvidenceUseCase $deleteMilestoneEvidenceUseCase) {}

    public function destroy(DeleteMilestoneEvidenceRequest $request): JsonResponse
    {
        try {
            $this->deleteMilestoneEvidenceUseCase->execute($request, AuthSession::getUserId());

            return new JsonResponse([
                'success' => true, 
                'message' => 'Xóa thành công'
            ]);
        } catch (DomainException $e) {
            return new JsonResponse([
                'success' => false, 
                'message' => $e->getMessage()
            ]);
        }
    }
}