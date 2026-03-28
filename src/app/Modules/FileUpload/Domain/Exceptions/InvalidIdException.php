<?php

namespace App\Modules\FileUpload\Domain\Exceptions;

use App\Shared\Domain\Exception\DomainException;

final class InvalidIdException extends DomainException
{
    public function __construct()
    {
        return parent::__construct('file ID invalid', "FILE_ID_INVALID");
    }
}