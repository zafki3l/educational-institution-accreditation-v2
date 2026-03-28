<?php

namespace App\Modules\QualityAssessment\Domain\Exception\Standard;

use App\Shared\Domain\Exception\DomainException;

final class StandardEmptyIdException extends DomainException
{
    public function __construct()
    {
        return parent::__construct(
            'Mã tiêu chuẩn không được bỏ trống!', 
            'STANDARD_ID_EMPTY'
        );
    }
}