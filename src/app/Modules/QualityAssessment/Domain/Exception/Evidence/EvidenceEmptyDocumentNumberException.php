<?php

namespace App\Modules\QualityAssessment\Domain\Exception\Evidence;

use App\Shared\Exception\DomainException;

final class EvidenceEmptyDocumentNumberException extends DomainException
{
    public function __construct()
    {
        parent::__construct(
            'Quyết định văn bản không được bỏ trống!',
            'EVIDENCE_DOCUMENT_NUMBER_EMPTY'
        );
    }
}

