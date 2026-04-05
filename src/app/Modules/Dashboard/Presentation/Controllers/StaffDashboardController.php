<?php
namespace App\Modules\Dashboard\Presentation\Controllers;

use App\Modules\Dashboard\Application\Readers\StaffDashboardReaderInterface;
use App\Modules\Dashboard\Presentation\ViewModels\StaffDashboardOverviewViewModel;
use App\Shared\Security\Session\AuthSession;
use App\Shared\Web\Responses\ViewResponse;

class StaffDashboardController extends DashboardController
{
    public function __construct(
        private StaffDashboardReaderInterface $staffDashboardReader,
        private AuthSession $authSession
    ) {}

    public function dashboard(): ViewResponse
    {
        $staff = $this->staffDashboardReader->getStaffInfo($this->authSession->authUser()->user_id);

        $first_criteria = $this->staffDashboardReader->getFirstCriteriaId($staff->department_id) ?? null;

        $overview = new StaffDashboardOverviewViewModel(
            $this->staffDashboardReader->getOverviewStandardManagementStats($staff->department_id),
            $staff,
            $first_criteria ? $first_criteria->first_criteria_id : null
        );

        return new ViewResponse(
            self::MODULE_NAME,
            'staff-dashboard/main',
            'main.layouts',
            [
                'title' => 'Trang điều khiển | ' . SYSTEM_NAME,
                'overview' => $overview,
            ]
        );
    }
}