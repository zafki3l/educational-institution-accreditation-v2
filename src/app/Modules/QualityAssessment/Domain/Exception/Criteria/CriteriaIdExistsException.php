<?php

namespace App\Modules\QualityAssessment\Domain\Exception\Criteria;

use App\Shared\Domain\Exception\DomainException;

final class CriteriaIdExistsException extends DomainException
{
    public function __construct()
    {
        return parent::__construct('Mã tiêu chí này đã tồn tại', 'CRITERIA_ID_EXISTS');
    }
}