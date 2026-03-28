<?php

namespace App\Modules\QualityAssessment\Domain\Exception\Evidence;

use App\Shared\Domain\Exception\DomainException;

final class EvidencePermissionAccessDeniedException extends DomainException
{
    public function __construct()
    {
        return parent::__construct('Người dùng không có quyền quản lý minh chứng thuộc tiêu chuẩn này!', 'EVIDENCE_PERMISSION_DENIED');
    }
}