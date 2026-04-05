<?php

namespace App\Modules\Dashboard\Infrastructure\Readers;

use App\Modules\Dashboard\Application\Readers\StaffDashboardReaderInterface;
use App\Modules\Dashboard\Application\Responses\FirstCriteriaIdResponse;
use App\Modules\Dashboard\Application\Responses\StaffInfoResponse;
use App\Modules\Dashboard\Application\Responses\StandardManagementStatsResponse;
use App\Modules\DepartmentManagement\Infrastructure\Models\Department;
use App\Modules\QualityAssessment\Application\Readers\CriteriaReaderInterface;
use App\Modules\QualityAssessment\Application\Readers\EvidenceReaderInterface;
use App\Modules\QualityAssessment\Application\Readers\MilestoneReaderInterface;
use App\Modules\QualityAssessment\Application\Readers\StandardReaderInterface;
use App\Modules\UserManagement\Infrastructure\Models\User;

class StaffDashboardReader implements StaffDashboardReaderInterface
{
    public function __construct(
        private StandardReaderInterface $standardReader,
        private CriteriaReaderInterface $criteriaReader,
        private MilestoneReaderInterface $milestoneReader,
        private EvidenceReaderInterface $evidenceReader
    ) {}

    public function getStaffInfo(string $staff_id): ?StaffInfoResponse
    {
        $staff = $staff_id ? User::with('department')->find($staff_id) : null;

        if (!$staff) {
            return null;
        }

        return new StaffInfoResponse(
            $staff->id,
            $staff->first_name,
            $staff->last_name,
            $staff->email,
            $staff->department->id,
            $staff->department->name
        );
    }

    public function getOverviewStandardManagementStats(string $department_id): StandardManagementStatsResponse
    {
        return new StandardManagementStatsResponse(
            $this->standardReader->count(),
            $this->criteriaReader->count(),
            $this->milestoneReader->count(),
            $this->evidenceReader->countByDepartment($department_id)
        );
    }

    public function getFirstCriteriaId(string $department_id): ?FirstCriteriaIdResponse
    {
        $department = (isStaff()) 
            ? Department::with('standards.criteria')->findOrFail($department_id)
            : '';

        $first_criteria = (isStaff()) ? $department->standards->first()?->criteria->first() : '';

        if (!$first_criteria) {
            return null;
        }

        return new FirstCriteriaIdResponse(
            isAdmin() ? '1.1' : $first_criteria->id
        );
    }
}
