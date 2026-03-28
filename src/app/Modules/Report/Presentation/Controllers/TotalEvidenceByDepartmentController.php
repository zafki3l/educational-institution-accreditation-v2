<?php

namespace App\Modules\Report\Presentation\Controllers;

use App\Modules\QualityAssessment\Infrastructure\Models\Evidence;
use App\Modules\UserManagement\Infrastructure\Models\User;
use App\Shared\Security\Session\AuthSession;
use App\Shared\Web\Responses\JsonResponse;

final class TotalEvidenceByDepartmentController extends ReportController
{
    public function getTotal()
    {
        $user = User::select('department_id')->findOrFail(AuthSession::getUserId());

        $total_evidences = Evidence::whereHas('milestone.criteria.standard', function ($query) use ($user) {
            $query->where('department_id', $user->department_id);
        })->count();

        return new JsonResponse([
            'total_evidences' => $total_evidences
        ]);
    }
}