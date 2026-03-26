<?php

namespace App\Modules\QualityAssessment\Presentation\Controllers\Criteria;

use App\Modules\QualityAssessment\Application\Readers\StandardReaderInterface;
use App\Modules\QualityAssessment\Presentation\Controllers\QualityAssessmentController;
use App\Shared\Response\ViewResponse;

final class IndexCriteriaController extends QualityAssessmentController
{
    public function __construct(private StandardReaderInterface $standardReader) {}

    public function index(): ViewResponse
    {
        $standards = $this->standardReader->withCriteria();

        $sidebarStandards = $this->renderSidebarStandards($this->standardReader);

        return new ViewResponse(
            self::MODULE_NAME,
            'criteria/index',
            'main.layouts',
            [
                'title' => (isAdmin()) ? 'Quản lý tiêu chí đánh giá' : 'Danh sách tiêu chí đánh giá' . ' | ' . SYSTEM_NAME,
                'header' => (isAdmin()) ? 'Quản lý tiêu chí đánh giá' : 'Danh sách tiêu chí đánh giá',
                'standards' => $standards,
                'sidebarStandards' => $sidebarStandards
            ]
        );
    }
}