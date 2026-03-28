<?php

namespace App\Modules\QualityAssessment\Domain\Exception\Standard;

use App\Shared\Domain\Exception\DomainException;

final class StandardEmptyDepartmentIdException extends DomainException
{
    public function __construct()
    {
        return parent::__construct(
            'Phòng ban không được bỏ trống!', 
            'STANDARD_NAME_EMPTY'
        );
    }
}