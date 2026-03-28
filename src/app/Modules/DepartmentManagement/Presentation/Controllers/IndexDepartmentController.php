<?php

namespace App\Modules\DepartmentManagement\Presentation\Controllers;

use App\Modules\DepartmentManagement\Application\Readers\DepartmentReaderInterface;
use App\Modules\DepartmentManagement\Application\Responses\DepartmentReaderResponse;
use App\Modules\DepartmentManagement\Presentation\ViewModels\IndexDepartmentViewModel;
use App\Shared\Web\Responses\ViewResponse;

final class IndexDepartmentController extends DepartmentController
{
    public function __construct(private DepartmentReaderInterface $departmentReader) {}

    public function index(): ViewResponse
    {
        $departments = array_map(
            fn (DepartmentReaderResponse $department) => new IndexDepartmentViewModel($department->id, $department->name),
            $this->departmentReader->all()
        );

        return new ViewResponse(
            self::MODULE_NAME,
            'index/main',
            'main.layouts',
            [
                'title' => 'Quản lý phòng ban | ' . SYSTEM_NAME,
                'departments' => $departments
            ]
        );
    }
}