<?php

namespace App\Modules\Dashboard\Application\Readers;

use App\Modules\Dashboard\Application\Responses\StandardManagementStatsResponse;
use App\Modules\Dashboard\Application\Responses\UserManagementStatsResponse;

interface AdminDashboardReaderInterface
{
    public function getOverviewUserManagementStats(): UserManagementStatsResponse;

    public function getOverviewStandardManagementStats(): StandardManagementStatsResponse;
}