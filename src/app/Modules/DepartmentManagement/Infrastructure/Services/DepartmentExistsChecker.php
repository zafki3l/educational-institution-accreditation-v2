<?php

namespace App\Modules\DepartmentManagement\Infrastructure\Services;

use App\Modules\DepartmentManagement\Domain\Entities\Department;
use App\Modules\DepartmentManagement\Domain\Exception\DepartmentNotFoundException;
use App\Modules\DepartmentManagement\Domain\Services\DepartmentExistsCheckerInterface;

final class DepartmentExistsChecker implements DepartmentExistsCheckerInterface
{
    public function check(?Department $department): void
    {
        if ($department === null) {
            throw new DepartmentNotFoundException();
        }
    }
}