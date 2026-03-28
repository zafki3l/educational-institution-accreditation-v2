<?php

namespace App\Modules\QualityAssessment\Domain\Exception\Standard;

use App\Shared\Domain\Exception\DomainException;

final class StandardInvalidIdException extends DomainException
{
    public function __construct()
    {
        return parent::__construct(
            'Mã tiêu chuẩn chỉ được chứa ký tự số và không dấu! ', 
            'STANDARD_ID_INVALID'
        );
    }
}