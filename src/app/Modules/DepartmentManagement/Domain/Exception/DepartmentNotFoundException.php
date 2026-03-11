<?php

namespace App\Modules\DepartmentManagement\Domain\Exception;

use App\Shared\Exception\DomainException;

final class DepartmentNotFoundException extends DomainException
{
    public function __construct()
    {
        parent::__construct(
            "Không tìm thấy phòng ban!",
            'DEPARTMENT_NOT_FOUND',
            404
        );
    }
}