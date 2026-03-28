<?php

namespace App\Modules\FileUpload\Domain\Exceptions;

use App\Shared\Domain\Exception\DomainException;

final class FileExtensionInvalidException extends DomainException
{
    public function __construct()
    {
        return parent::__construct('Hệ thống chỉ hỗ trợ định dạng file jpg, png, webp và pdf!', "FILE_EXT_INVALID");
    }
}