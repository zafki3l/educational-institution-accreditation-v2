<?php

namespace App\Modules\Dashboard\Infrastructure\Readers;

use App\Modules\Authorization\Application\Readers\RoleReaderInterface;
use App\Modules\Authorization\Domain\Entities\Role;
use App\Modules\Dashboard\Application\Readers\AdminDashboardReaderInterface;
use App\Modules\Dashboard\Application\Responses\StandardManagementStatsResponse;
use App\Modules\Dashboard\Application\Responses\UserManagementStatsResponse;
use App\Modules\DepartmentManagement\Application\Readers\DepartmentReaderInterface;
use App\Modules\QualityAssessment\Infrastructure\Models\Evidence;
use App\Modules\QualityAssessment\Infrastructure\Models\Milestone;
use App\Modules\UserManagement\Application\Readers\UserReaderInterface;
use App\Shared\Application\Contracts\CriteriaReader\CriteriaReaderInterface;
use App\Shared\Application\Contracts\StandardReader\StandardReaderInterface;

class AdminDashboardReader implements AdminDashboardReaderInterface
{
    public function __construct(
        private UserReaderInterface $userReader,
        private DepartmentReaderInterface $departmentReader,
        private RoleReaderInterface $roleReader,
        private StandardReaderInterface $standardReader,
        private CriteriaReaderInterface $criteriaReader,
    ) {}

    public function getOverviewUserManagementStats(): UserManagementStatsResponse
    {
        return new UserManagementStatsResponse(
            $this->userReader->count(),
            $this->userReader->countByRoleId(Role::ROLE_STAFF),
            $this->departmentReader->count(),
            $this->roleReader->count()
        );
    }

    public function getOverviewStandardManagementStats(): StandardManagementStatsResponse
    {
        return new StandardManagementStatsResponse(
            $this->standardReader->count(),
            $this->criteriaReader->count(),
            Milestone::count(),
            Evidence::count()
        );
    }
}