<?php

namespace App\Modules\QualityAssessment\Domain\Exception\Milestone;

use App\Shared\Domain\Exception\DomainException;

final class MilestoneCodeInvalidException extends DomainException
{
    public function __construct()
    {
        return parent::__construct("Milestone code không hợp lệ! Phải là {criteria_id}.{order}", 'MILESTONE_ORDER_INVALID');
    }
}