<?php

namespace App\Modules\QualityAssessment\Domain\Exception\Milestone;

use App\Shared\Domain\Exception\DomainException;

final class MilestoneIdEmptyException extends DomainException
{
    public function __construct()
    {
        return parent::__construct(
            'Mã mốc đánh giá không được bỏ trống!', 
            'MILESTONE_ID_EMPTY'
        );
    }
}