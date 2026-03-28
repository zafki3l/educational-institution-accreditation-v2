<?php

namespace App\Modules\FileUpload\Domain\Exceptions;

use App\Shared\Domain\Exception\DomainException;

final class SizeTooBigException extends DomainException
{
    public function __construct()
    {
        return parent::__construct('file quá lớn! Vui lòng thử lại (Tối đa: 20 mb)', "FILE_SIZE_TOO_BIG");
    }
}