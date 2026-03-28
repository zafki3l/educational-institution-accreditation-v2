<?php

namespace App\Modules\UserManagement\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;

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