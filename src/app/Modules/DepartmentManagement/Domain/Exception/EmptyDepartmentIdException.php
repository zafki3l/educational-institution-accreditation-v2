<?php

namespace App\Modules\DepartmentManagement\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;

final class EmptyDepartmentIdException extends DomainException
{
    public function __construct()
    {
        parent::__construct(
            "Không được bỏ trống department id!",
            'DEPARTMENT_ID_EMPTY',
            404
        );
    }
}