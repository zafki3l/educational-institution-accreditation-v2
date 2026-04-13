<?php

namespace App\Modules\FileUpload\Domain\Exceptions;

use App\Shared\Domain\Exception\DomainException;

final class FileUploadInvalidException extends DomainException
{
    public function __construct()
    {
        return parent::__construct('File upload không hợp lệ, vui lòng thử lại!', 'FILE_UPLOAD_INVALID');
    }
}
