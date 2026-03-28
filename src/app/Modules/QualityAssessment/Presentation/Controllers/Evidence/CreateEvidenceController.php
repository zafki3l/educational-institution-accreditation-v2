<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers\Evidence;

use App\Modules\QualityAssessment\Application\Readers\StandardReaderInterface;
use App\Modules\QualityAssessment\Application\UseCases\Evidence\CreateEvidenceUseCase;
use App\Modules\QualityAssessment\Infrastructure\Models\Criteria;
use App\Modules\QualityAssessment\Infrastructure\Models\Milestone;
use App\Modules\QualityAssessment\Infrastructure\Models\Standard;
use App\Modules\QualityAssessment\Presentation\Controllers\QualityAssessmentController;
use App\Modules\QualityAssessment\Presentation\Requests\Evidence\CreateEvidenceRequest;
use App\Shared\Domain\Exception\DomainException;
use App\Shared\Response\JsonResponse;
use App\Shared\Response\ViewResponse;
use App\Shared\SessionManager\AuthSession;

final class CreateEvidenceController extends QualityAssessmentController
{
    public function __construct(
        private CreateEvidenceUseCase $createEvidenceUseCase,
        private StandardReaderInterface $standardReader
    ) {}

    public function create(): ViewResponse
    {
        $sidebarStandards = $this->renderSidebarStandards($this->standardReader);

        return new ViewResponse(
            self::MODULE_NAME,
            'evidence/create',
            'main.layouts',
            [
                'title' => 'Thêm minh chứng đánh giá | ' . SYSTEM_NAME,
                'sidebarStandards' => $sidebarStandards
            ]
        );
    }

    public function getAllStandard()
    {
        $standards = (isAdmin()) 
            ? Standard::select('id', 'name')->orderByRaw('CAST(id AS UNSIGNED) ASC')->get()
            : $this->renderSidebarStandards($this->standardReader);

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

    public function store(CreateEvidenceRequest $request): void
    {
        try {
            $this->createEvidenceUseCase->execute($request, AuthSession::getUserId());

            $this->redirect("/criterias/{$request->getCriteriaId()}/evidences?success=created");
        } catch (DomainException $e) {
            $_SESSION['errors'] = [$e->getMessage()];

            $_SESSION['old'] = $_POST;
            $this->redirect('/evidences/create');
        }
    }
}