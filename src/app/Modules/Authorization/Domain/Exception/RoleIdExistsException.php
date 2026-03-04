<?php

namespace App\Modules\Authorization\Domain\Exception;

use App\Shared\Exception\DomainException;

final class RoleIdExistsException extends DomainException
{
    public function __construct()
    {
        parent::__construct(
            "Vai trò không thể bị ghi đè!",
            'ROLE_ID_EMPTY',
            404
        );
    }
}