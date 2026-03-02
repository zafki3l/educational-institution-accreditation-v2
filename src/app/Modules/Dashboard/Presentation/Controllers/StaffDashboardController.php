<?php
namespace App\Modules\Dashboard\Presentation\Controllers;

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
        $total_standards =  $this->standardReader->count();
        $total_criterias = $this->criteriaReader->count();
        $total_milestones = Milestone::count();
        $total_evidences = Evidence::count();

        return new ViewResponse(
            self::MODULE_NAME,
            'staff-dashboard/main',
            'main.layouts',
            [
                'title' => 'Trang điều khiển | ' . SYSTEM_NAME,
                'total_standards' => $total_standards,
                'total_criterias' => $total_criterias,
                'total_milestones' => $total_milestones,
                'total_evidences' => $total_evidences
            ]
        );
    }
}