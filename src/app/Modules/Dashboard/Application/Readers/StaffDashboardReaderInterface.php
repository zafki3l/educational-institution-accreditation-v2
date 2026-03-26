<?php

namespace App\Modules\Dashboard\Application\Readers;

use App\Modules\Dashboard\Application\Responses\FirstCriteriaIdResponse;
use App\Modules\Dashboard\Application\Responses\StaffInfoResponse;
use App\Modules\Dashboard\Application\Responses\StandardManagementStatsResponse;

interface StaffDashboardReaderInterface
{
    public function getStaffInfo(string $staff_id): ?StaffInfoResponse;

    public function getOverviewStandardManagementStats(string $department_id): StandardManagementStatsResponse;

    public function getFirstCriteriaId(string $staff_id): FirstCriteriaIdResponse;
}