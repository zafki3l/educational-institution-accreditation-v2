<?php

namespace App\Modules\QualityAssessment\Domain\Exception\Criteria;

use App\Shared\Domain\Exception\DomainException;

final class CriteriaEmptyNameException extends DomainException
{
    public function __construct()
    {
        return parent::__construct(
            'Tên tiêu chí không được bỏ trống!', 
            'CRITERIA_NAME_EMPTY'
        );
    }
}