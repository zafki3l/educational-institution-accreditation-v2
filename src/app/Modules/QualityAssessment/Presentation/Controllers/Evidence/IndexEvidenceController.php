<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers\Evidence;

use App\Modules\DepartmentManagement\Infrastructure\Models\Department;
use App\Modules\QualityAssessment\Infrastructure\Models\Criteria;
use App\Modules\QualityAssessment\Infrastructure\Models\Evidence;
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
        $criteria = Criteria::with('milestones.criteria')->findOrFail($criteria_id);

        // lấy all evidences liên quan
        $evidences = Evidence::with('milestones')
            ->whereIn(
                'milestone_id',
                $criteria->milestones->pluck('id')
            )->orWhereHas('milestones', function ($q) use ($criteria) {
                $q->whereIn('milestones.id', $criteria->milestones->pluck('id'));
            })->get();

        // group raw trước
        $grouped = [];

        foreach ($evidences as $e) {
            // primary
            if ($e->milestone_id) {
                $grouped[$e->milestone_id][] = $e;
            }

            // pivot
            foreach ($e->milestones as $m) {
                $grouped[$m->id][] = $e;
            }
        }

        // map sang structure cho view
        $evidencesByMilestone = [];

        foreach ($criteria->milestones as $milestone) {
            $evidencesByMilestone[$milestone->id] = collect($grouped[$milestone->id] ?? [])
                ->unique('id')
                ->values();
        }

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
                'sidebarStandards' => $sidebarStandards,
                'evidencesByMilestone' => $evidencesByMilestone
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