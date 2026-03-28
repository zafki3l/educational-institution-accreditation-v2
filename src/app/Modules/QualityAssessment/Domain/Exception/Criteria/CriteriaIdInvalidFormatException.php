<?php

namespace App\Modules\QualityAssessment\Domain\Exception\Criteria;

use App\Shared\Domain\Exception\DomainException;

final class CriteriaIdInvalidFormatException extends DomainException
{
    public function __construct()
    {
        parent::__construct(
            'Mã tiêu chí phải có dạng {standard_id}.{số thứ tự}',
            'CRITERIA_ID_INVALID'
        );
    }
}