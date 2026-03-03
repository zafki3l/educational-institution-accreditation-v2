<?php

namespace App\Modules\UserProfile\Domain\Exceptions;

use App\Shared\Exception\DomainException;

final class EmailExistException extends DomainException
{
    public function __construct()
    {
        parent::__construct(
            'Email này đã được sử dụng!', 
            "EMAIL_ALREADY_EXIST"
        );
    }
}