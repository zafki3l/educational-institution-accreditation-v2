<?php

namespace App\Modules\QualityAssessment\Domain\Exception\Milestone;

use App\Shared\Domain\Exception\DomainException;

final class MilestoneOrderInvalidException extends DomainException
{
    public function __construct()
    {
        return parent::__construct("Số thứ tự phải lớn hơn 0!", 'MILESTONE_ORDER_INVALID');
    }
}