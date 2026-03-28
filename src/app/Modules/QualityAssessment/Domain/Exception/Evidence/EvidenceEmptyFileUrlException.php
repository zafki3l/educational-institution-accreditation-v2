<?php

namespace App\Modules\QualityAssessment\Domain\Exception\Evidence;

use App\Shared\Domain\Exception\DomainException;

final class EvidenceEmptyFileUrlException extends DomainException
{
    public function __construct()
    {
        parent::__construct(
            'Đường dẫn file minh chứng không được bỏ trống!',
            'EVIDENCE_FILE_URL_EMPTY'
        );
    }
}

