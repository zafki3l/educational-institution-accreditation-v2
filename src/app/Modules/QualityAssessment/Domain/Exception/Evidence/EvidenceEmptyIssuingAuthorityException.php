<?php

namespace App\Modules\QualityAssessment\Domain\Exception\Evidence;

use App\Shared\Exception\DomainException;

final class EvidenceEmptyIssuingAuthorityException extends DomainException
{
    public function __construct()
    {
        parent::__construct(
            'Nơi phát hành không được bỏ trống!',
            'EVIDENCE_ISSUING_AUTHORITY_EMPTY'
        );
    }
}

