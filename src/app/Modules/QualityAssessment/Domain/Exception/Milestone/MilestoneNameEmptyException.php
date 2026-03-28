<?php

namespace App\Modules\QualityAssessment\Domain\Exception\Milestone;

use App\Shared\Domain\Exception\DomainException;

final class MilestoneNameEmptyException extends DomainException
{
    public function __construct()
    {
        return parent::__construct(
            'Tên mốc đánh giá không được bỏ trống!', 
            'MILESTONE_NAME_EMPTY'
        );
    }
}