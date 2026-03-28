<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers\Standard;

use App\Modules\DepartmentManagement\Application\Readers\DepartmentReaderInterface;
use App\Modules\QualityAssessment\Application\Readers\StandardReaderInterface;
use App\Modules\QualityAssessment\Presentation\Controllers\QualityAssessmentController;
use App\Shared\Web\Responses\ViewResponse;

final class IndexStandardController extends QualityAssessmentController
{
    public function __construct(
        private StandardReaderInterface $standardReader,
        private DepartmentReaderInterface $departmentReader
    ) {}

    public function index(): ViewResponse
    {
        $standards = $this->standardReader->all();
        $sidebarStandards = $this->renderSidebarStandards($this->standardReader);
        $departments = $this->departmentReader->all();

        return new ViewResponse(
            self::MODULE_NAME,
            'standard/index',
            'main.layouts',
            [
                'title' => isAdmin() ? 'Quản lý tiêu chuẩn đánh giá' : 'Danh sách tiêu chuẩn đánh giá' . ' | ' . SYSTEM_NAME,
                'header' => isAdmin() ? 'Quản lý tiêu chuẩn đánh giá' : 'Danh sách tiêu chuẩn đánh giá',
                'standards' => $standards,
                'departments' => $departments,
                'sidebarStandards' => $sidebarStandards
            ]
        );
    }
}