<?php

namespace App\Modules\DepartmentManagement\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;

final class EmptyDepartmentNameException extends DomainException
{
    public function __construct()
    {
        parent::__construct(
            "Không được bỏ trống department name!",
            'DEPARTMENT_NAME_EMPTY',
            404
        );
    }
}