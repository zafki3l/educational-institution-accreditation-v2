<?php

namespace App\Modules\Dashboard\Presentation\Controllers;

use App\Modules\Authorization\Application\Readers\RoleReaderInterface;
use App\Modules\DepartmentManagement\Application\Readers\DepartmentReaderInterface;
use App\Modules\QualityAssessment\Infrastructure\Models\Evidence;
use App\Modules\QualityAssessment\Infrastructure\Models\Milestone;
use App\Modules\UserManagement\Application\Readers\UserReaderInterface;
use App\Shared\Application\Contracts\CriteriaReader\CriteriaReaderInterface;
use App\Shared\Application\Contracts\StandardReader\StandardReaderInterface;
use App\Shared\Domain\UserRole;
use App\Shared\Response\ViewResponse;

final class AdminDashboardController extends DashboardController
{
    public function __construct(
        private UserReaderInterface $userReader,
        private DepartmentReaderInterface $departmentReader,
        private RoleReaderInterface $roleReader,
        private StandardReaderInterface $standardReader,
        private CriteriaReaderInterface $criteriaReader,
    ) {}

    public function dashboard(): ViewResponse
    {
        $total_users = $this->userReader->count();
        $total_staffs = $this->userReader->countByRoleId(UserRole::ROLE_STAFF);
        $total_departments = $this->departmentReader->count();
        $total_roles = $this->roleReader->count();
        $total_standards =  $this->standardReader->count();
        $total_criterias = $this->criteriaReader->count();
        $total_milestones = Milestone::count();
        $total_evidences = Evidence::count();
        
        return new ViewResponse(
            self::MODULE_NAME,
            'admin-dashboard/main',
            'main.layouts',
            [
                'title' => 'Trang điều khiển Admin | ' . SYSTEM_NAME,
                'total_users' => $total_users,
                'total_staffs' => $total_staffs,
                'total_departments' => $total_departments,
                'total_roles' => $total_roles,
                'total_standards' => $total_standards,
                'total_criterias' => $total_criterias,
                'total_milestones' => $total_milestones,
                'total_evidences' => $total_evidences
            ]
        );
    }
}