<?php

namespace App\Modules\QualityAssessment\Domain\Exception\Milestone;

use App\Shared\Domain\Exception\DomainException;

final class MilestoneInvalidIdException extends DomainException
{
    public function __construct()
    {
        return parent::__construct(
            'Mã mốc đánh giá phải được đánh số thứ tự từ 1 trở lên!',
            'MILESTONE_ID_INVALID'
        );
    }
}