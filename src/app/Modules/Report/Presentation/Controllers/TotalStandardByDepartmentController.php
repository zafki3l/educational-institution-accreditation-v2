<?php

namespace App\Modules\Report\Presentation\Controllers;

use App\Modules\DepartmentManagement\Infrastructure\Models\Department;
use App\Modules\QualityAssessment\Infrastructure\Models\Standard;
use App\Shared\Response\JsonResponse;

final class TotalStandardByDepartmentController extends ReportController
{
    public function totalByDepartment(string $id): JsonResponse
    {
        $department = Department::with('standards')->findOrFail($id);

        $total_standards = Standard::where('department_id', $id)->count();

        return new JsonResponse([
            'department' => $department,
            'total_standards' => $total_standards
        ]);
    }

    public function totalByAllDepartment(): JsonResponse
    {
        $department = Department::with('standards')
                        ->withCount('standards')
                        ->get();

        $total_standards = Standard::count();

        return new JsonResponse([
            'department' => $department,
            'total_standards' => $total_standards
        ]);
    }
}