<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers;

use App\Modules\QualityAssessment\Application\Readers\StandardReaderInterface;
use App\Modules\UserManagement\Infrastructure\Models\User;
use App\Shared\Security\Session\AuthSession;
use App\Shared\Web\Http\HttpResponse;
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