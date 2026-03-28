<?php

namespace App\Modules\QualityAssessment\Domain\Exception\Evidence;

use App\Shared\Domain\Exception\DomainException;

final class EvidenceIdExistsException extends DomainException
{
    public function __construct()
    {
        return parent::__construct('Mã minh chứng này đã tồn tại', 'MILESTONE_ID_EXISTS');
    }
}