<?php

namespace App\Modules\DepartmentManagement\Domain\Services;

use App\Modules\DepartmentManagement\Domain\Entities\Department;

interface DepartmentExistsCheckerInterface
{
    public function check(?Department $department): void;
}