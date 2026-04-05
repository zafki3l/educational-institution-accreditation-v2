<?php

namespace App\Modules\Dashboard\Presentation\ViewModels;

use App\Modules\Dashboard\Application\Responses\StaffInfoResponse;
use App\Modules\Dashboard\Application\Responses\StandardManagementStatsResponse;

final class StaffDashboardOverviewViewModel
{
    public function __construct(
        public readonly StandardManagementStatsResponse $standardManagement,
        public readonly StaffInfoResponse $staffInfo,
        public readonly ?string $first_criteria_id
    ) {}
}