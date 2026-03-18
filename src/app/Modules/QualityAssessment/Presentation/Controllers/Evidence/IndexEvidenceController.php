<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers\Evidence;

use App\Modules\DepartmentManagement\Infrastructure\Models\Department;
use App\Modules\QualityAssessment\Infrastructure\Models\Criteria;
use App\Modules\QualityAssessment\Presentation\Controllers\QualityAssessmentController;
use App\Modules\UserManagement\Infrastructure\Models\User;
use App\Shared\Application\Contracts\StandardReader\StandardReaderInterface;
use App\Shared\Response\ViewResponse;

final class IndexEvidenceController extends QualityAssessmentController
{
    public function __construct(private StandardReaderInterface $standardReader) {}

    public function index(string $criteria_id)
    {
        if (!isAdmin()) {
            $this->checkAllowedCriteriaIds($criteria_id);
        }

        $standards = $this->standardReader->withCriteria();
        $sidebarStandards = $this->renderSidebarStandards($this->standardReader);
        $criteria = Criteria::with(['milestones', 'milestones.criteria', 'milestones.evidences'])->findOrFail($criteria_id);

        return new ViewResponse(
            self::MODULE_NAME,
            'evidence/index',
            'main.layouts',
            [
                'title' => 'Quản lý minh chứng đánh giá | ' . SYSTEM_NAME,
                'standards' => $standards,
                'criteria' => $criteria,
                'criteriaId' => $criteria->id,
                'criteriaName' => $criteria->name,
                'sidebarStandards' => $sidebarStandards
            ]
        );
    }

    private function checkAllowedCriteriaIds(string $criteria_id): void
    {
        $user_id = $_SESSION['auth_user']['user_id'] ?? null;
        $user = $user_id ? User::with('department')->find($user_id) : null;

        $department = Department::with('standards.criteria')->findOrFail($user->department->id);
        
        $allowedCriteriaIds = $department->standards->flatMap(function ($standard) {
            return $standard->criteria->pluck('id');
        })->toArray();

        if (!in_array($criteria_id, $allowedCriteriaIds)) {
            $fallbackCriteria = $department->standards->first()?->criteria->first();
            
            $this->redirect("/criterias/{$fallbackCriteria->id}/evidences");
        }
    }
}