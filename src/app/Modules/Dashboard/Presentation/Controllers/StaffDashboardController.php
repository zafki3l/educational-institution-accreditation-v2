<?php
namespace App\Modules\Dashboard\Presentation\Controllers;

use App\Modules\DepartmentManagement\Infrastructure\Models\Department;
use App\Modules\UserManagement\Infrastructure\Models\User;
use App\Modules\QualityAssessment\Infrastructure\Models\Evidence;
use App\Modules\QualityAssessment\Infrastructure\Models\Milestone;
use App\Shared\Application\Contracts\CriteriaReader\CriteriaReaderInterface;
use App\Shared\Application\Contracts\StandardReader\StandardReaderInterface;
use App\Shared\Response\ViewResponse;

class StaffDashboardController extends DashboardController
{
    public function __construct(
        private StandardReaderInterface $standardReader,
        private CriteriaReaderInterface $criteriaReader,
    ) {}

    public function dashboard(): ViewResponse
    {
        $total_standards = $this->standardReader->count();
        $total_criterias = $this->criteriaReader->count();
        $total_milestones = Milestone::count();
        $total_evidences = Evidence::count();
        
        $user_id = $_SESSION['auth_user']['user_id'] ?? null;
        $user = $user_id ? User::with('department')->find($user_id) : null;

        $department = (isStaff()) 
            ? Department::with('standards.criteria')->findOrFail($user->department->id)
            : '';

        $first_criteria = (isStaff()) ? $department->standards->first()?->criteria->first() : '';

        return new ViewResponse(
            self::MODULE_NAME,
            'staff-dashboard/main',
            'main.layouts',
            [
                'title' => 'Trang điều khiển | ' . SYSTEM_NAME,
                'total_standards' => $total_standards,
                'total_criterias' => $total_criterias,
                'total_milestones' => $total_milestones,
                'total_evidences' => $total_evidences,
                'user' => $user,
                'first_criteria_id' => isAdmin() ? '1.1' : $first_criteria->id
            ]
        );
    }
}