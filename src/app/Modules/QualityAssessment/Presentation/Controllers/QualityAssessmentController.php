<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers;

use App\Modules\UserManagement\Infrastructure\Models\User;
use App\Shared\Application\Contracts\StandardReader\StandardReaderInterface;
use App\Shared\Http\Traits\HttpResponse;
use App\Shared\SessionManager\AuthSession;
use Illuminate\Database\Eloquent\Collection;

abstract class QualityAssessmentController
{
    use HttpResponse;

    public const MODULE_NAME = 'QualityAssessment';

    protected function renderSidebarStandards(StandardReaderInterface $standardReader): Collection
    {
        if (isAdmin()) {
            $sidebarStandards = $standardReader->withCriteria();
        } else {
            $staff = User::select('department_id')->where('id', AuthSession::getUserId())->first();

            $sidebarStandards = $standardReader->withCriteriaByDepartment($staff->department_id);
        }

        return $sidebarStandards;
    }
}