<?php

namespace App\Modules\StaffManagement\Presentation\Controllers;

use App\Modules\DepartmentManagement\Application\Readers\DepartmentReaderInterface;
use App\Modules\UserManagement\Application\Readers\UserReaderInterface;
use App\Shared\Response\ViewResponse;

final class IndexStaffController extends StaffController
{
    public function __construct(
        private UserReaderInterface $userReader,
        private DepartmentReaderInterface $departmentReader
    ) {}

    public function index(): ViewResponse
    {
        $keyword = $_GET['keyword'] ?? null;
        $results = $this->userReader->allStaffs($keyword);
        $departments = $this->departmentReader->all();

        return new ViewResponse(
            self::MODULE_NAME, 
            'index/main', 
            'main.layouts',
            [
                'title' => 'Quản lý nhân viên | ' . SYSTEM_NAME,
                'staffs' => $results->items,
                'pagination' => $results,
                'departments' => $departments
            ]
        );
    }
}