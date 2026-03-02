<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers\Standard;

use App\Modules\QualityAssessment\Presentation\Controllers\QualityAssessmentController;
use App\Shared\Application\Contracts\DepartmentReader\DepartmentReaderInterface;
use App\Shared\Application\Contracts\StandardReader\StandardReaderInterface;
use App\Shared\Response\ViewResponse;

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
                'title' => 'Quản lý tiêu chuẩn đánh giá | ' . SYSTEM_NAME,
                'standards' => $standards,
                'departments' => $departments,
                'sidebarStandards' => $sidebarStandards
            ]
        );
    }
}