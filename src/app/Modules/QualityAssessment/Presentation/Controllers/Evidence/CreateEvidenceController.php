<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers\Evidence;

use App\Modules\QualityAssessment\Infrastructure\Models\Criteria;
use App\Modules\QualityAssessment\Infrastructure\Models\Evidence;
use App\Modules\QualityAssessment\Infrastructure\Models\Milestone;
use App\Modules\QualityAssessment\Infrastructure\Models\Standard;
use App\Modules\QualityAssessment\Presentation\Controllers\QualityAssessmentController;
use App\Modules\QualityAssessment\Presentation\Requests\Evidence\CreateEvidenceRequest;
use App\Shared\Response\JsonResponse;
use App\Shared\Response\ViewResponse;

final class CreateEvidenceController extends QualityAssessmentController
{
    public function create()
    {
        return new ViewResponse(
            self::MODULE_NAME,
            'evidence/create',
            'main.layouts',
            [
                'title' => 'Thêm minh chứng đánh giá'
            ]
        );
    }

    public function getAllStandard()
    {
        $standards = Standard::select('id', 'name')->orderByRaw('CAST(id AS UNSIGNED) ASC')->get();

        return new JsonResponse([
            'standards' => $standards
        ]);
    }

    public function getAllCriteriasByStandard(string $standard_id)
    {
        $criterias = Criteria::select('id', 'name')->where('standard_id', $standard_id)->get();

        return new JsonResponse([
            'criterias' => $criterias
        ]);
    }

    public function getAllMilestonesByCriteria(string $criteria_id)
    {
        $milestones = Milestone::select('id', 'name', 'order')->where('criteria_id', $criteria_id)->get();

        return new JsonResponse([
            'milestones' => $milestones
        ]);
    }

    public function store(CreateEvidenceRequest $request)
    {
        Evidence::create([
            'id' => $request->getId(),
            'name' => $request->getName(),
            'milestone_id' => $request->getMilestoneId(),
            'document_number' => $request->getDocumentNumber(),
            'issued_date' => $request->getIssuedDate(),
            'issuing_authority' => $request->getIssuingAuthority()
        ]);

        $this->redirect("/criterias/{$request->getCriteriaId()}/evidences");
    }
}