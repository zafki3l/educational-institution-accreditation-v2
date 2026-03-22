<?php

namespace App\Modules\Dashboard\Presentation\ViewModels;

use App\Modules\Dashboard\Application\Responses\StandardManagementStatsResponse;
use App\Modules\Dashboard\Application\Responses\UserManagementStatsResponse;

final class AdminDashboardOverviewViewModel
{
    public function __construct(
        public readonly UserManagementStatsResponse $userManagement,
        public readonly StandardManagementStatsResponse $standardManagement
    ) {}
}