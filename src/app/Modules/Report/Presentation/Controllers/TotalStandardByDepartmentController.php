<?php

namespace App\Modules\Report\Presentation\Controllers;

use App\Modules\DepartmentManagement\Infrastructure\Models\Department;
use App\Modules\QualityAssessment\Infrastructure\Models\Standard;
use App\Modules\UserManagement\Infrastructure\Models\User;
use App\Shared\Web\Responses\JsonResponse;

final class TotalStandardByDepartmentController extends ReportController
{
    public function totalByDepartment(string $id): JsonResponse
    {
        $department = Department::with('standards.criteria')->findOrFail($id);

        $total_standards = Standard::where('department_id', $id)->count();

        return new JsonResponse([
            'department' => $department,
            'total_standards' => $total_standards
        ]);
    }

    public function totalByAllDepartment(): JsonResponse
    {
        $departments = Department::select('id', 'name')
            ->with([
                'standards' => function ($q) {
                    $q->select('id', 'department_id', 'name')
                        ->withCount([
                            'criteria',
                            'criteria as evidences_count' => function ($q) {
                                $q->join('milestones', 'milestones.criteria_id', '=', 'criterias.id')
                                    ->join('evidences', 'evidences.milestone_id', '=', 'milestones.id');
                            }
                        ]);
                }
            ])
            ->withCount('standards')
            ->get();

        $data = $departments->map(function ($dept) {

            $criteriaCount = $dept->standards->sum('criteria_count');
            $evidenceCount = $dept->standards->sum('evidences_count');

            return [
                'id' => $dept->id,
                'name' => $dept->name,
                'standards_count' => $dept->standards_count,
                'criteria_count' => $criteriaCount,
                'evidences_count' => $evidenceCount,
                'standards' => $dept->standards->map(function ($s) {
                    return [
                        'id' => $s->id,
                        'name' => $s->name,
                    ];
                })
            ];
        });

        $totalStandards = Standard::count();

        return new JsonResponse([
            'departments' => $data,
            'total_standards' => $totalStandards
        ]);
    }

    public function standardsByStaffDepartment(): JsonResponse
    {
        $user_id = $_SESSION['auth_user']['user_id'] ?? null;
        if (!$user_id) {
            return new JsonResponse(['error' => 'Unauthenticated'], 401);
        }

        $user = User::find($user_id);
        if (!$user || !$user->department_id) {
            return new JsonResponse(['standards' => []]);
        }

        $department_id = $user->department_id;

        $standards = Standard::where('department_id', $department_id)
            ->withCount([
                'criteria',
                'criteria as evidences_count' => function ($q) {
                    $q->join('milestones', 'milestones.criteria_id', '=', 'criterias.id')
                        ->join('evidences', 'evidences.milestone_id', '=', 'milestones.id');
                }
            ])
            ->get();

        $data = $standards->map(function ($s) {
            return [
                'id'              => $s->id,
                'name'            => $s->name,
                'criteria_count'  => $s->criteria_count ?? 0,
                'evidences_count' => $s->evidences_count ?? 0,
            ];
        });

        return new JsonResponse(['standards' => $data]);
    }
}
