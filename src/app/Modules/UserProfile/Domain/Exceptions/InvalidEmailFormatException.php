<?php

namespace App\Modules\UserProfile\Domain\Exceptions;

use App\Shared\Domain\Exception\DomainException;

class InvalidEmailFormatException extends DomainException
{
    public function __construct()
    {
        parent::__construct(
            "Định dạng email không phù hợp!",
            "INVALID_EMAIL_FORMAT",
        );
    }
}