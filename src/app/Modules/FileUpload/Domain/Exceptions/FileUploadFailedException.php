<?php

namespace App\Modules\FileUpload\Domain\Exceptions;

use App\Shared\Domain\Exception\DomainException;

final class FileUploadFailedException extends DomainException
{
    public function __construct()
    {
        return parent::__construct('Upload file thất bại, vui lòng thử lại!', 'FILE_UPLOAD_FAILED');
    }
}
