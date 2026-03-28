<?php

namespace App\Modules\QualityAssessment\Domain\Exception\Evidence;

use App\Shared\Domain\Exception\DomainException;

final class EvidenceEmptyNameException extends DomainException
{
    public function __construct()
    {
        parent::__construct(
            'Tên minh chứng không được bỏ trống!',
            'EVIDENCE_NAME_EMPTY'
        );
    }
}

