<?php

namespace App\Modules\QualityAssessment\Domain\Exception\Standard;

use App\Shared\Domain\Exception\DomainException;

final class StandardEmptyNameException extends DomainException
{
    public function __construct()
    {
        return parent::__construct(
            'Tên tiêu chuẩn không được bỏ trống!', 
            'STANDARD_NAME_EMPTY'
        );
    }
}