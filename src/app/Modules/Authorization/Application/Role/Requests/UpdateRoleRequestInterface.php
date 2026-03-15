<?php

namespace App\Modules\Authorization\Application\Role\Requests;

interface UpdateRoleRequestInterface
{
    public function getId(): int;

    public function getName(): string;
}
