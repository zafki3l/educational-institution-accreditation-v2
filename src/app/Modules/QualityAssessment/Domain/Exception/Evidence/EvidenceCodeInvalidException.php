<?php

namespace App\Modules\QualityAssessment\Domain\Exception\Evidence;

use App\Shared\Domain\Exception\DomainException;

final class EvidenceCodeInvalidException extends DomainException
{
    public function __construct()
    {
        parent::__construct(
            "Mã minh chứng không hợp lệ! Mã phải theo định dạng Hn.ab.cd.ef (ví dụ: H1.01.01.01)",
            'EVIDENCE_CODE_INVALID'
        );
    }
}
