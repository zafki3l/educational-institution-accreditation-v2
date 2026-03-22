<?php

namespace App\Modules\Dashboard\Presentation\Controllers;

use App\Modules\Dashboard\Application\Readers\AdminDashboardReaderInterface;
use App\Modules\Dashboard\Presentation\ViewModels\AdminDashboardOverviewViewModel;
use App\Shared\Response\ViewResponse;

final class AdminDashboardController extends DashboardController
{
    public function __construct(private AdminDashboardReaderInterface $adminDashboardReader) {}

    public function dashboard(): ViewResponse
    {
        $overview = new AdminDashboardOverviewViewModel(
            $this->adminDashboardReader->getOverviewUserManagementStats(),
            $this->adminDashboardReader->getOverviewStandardManagementStats()
        );
        
        return new ViewResponse(
            self::MODULE_NAME,
            'admin-dashboard/main',
            'main.layouts',
            [
                'title' => 'Trang điều khiển Admin | ' . SYSTEM_NAME,
                'overview' => $overview
            ]
        );
    }
}