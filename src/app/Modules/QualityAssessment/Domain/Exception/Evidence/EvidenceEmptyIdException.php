<?php

namespace App\Modules\QualityAssessment\Domain\Exception\Evidence;

use App\Shared\Domain\Exception\DomainException;

final class EvidenceEmptyIdException extends DomainException
{
    public function __construct()
    {
        parent::__construct(
            'Mã minh chứng không được bỏ trống!',
            'EVIDENCE_ID_EMPTY'
        );
    }
}

