<?php

namespace App\Modules\UserManagement\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;

final class RoleMissingException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Vui lòng chọn vai trò!', "ROLE_MISSING");
    }
}