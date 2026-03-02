<?php

use App\Modules\Authorization\Domain\Entities\Role;

function isAuth(): bool {
    return isset($_SESSION['auth_user']);
}

function isAdmin(): bool {
    return $_SESSION['auth_user']['role_id'] === Role::ROLE_ADMIN;
}

function isStaff(): bool {
    return $_SESSION['auth_user']['role_id'] === Role::ROLE_STAFF;
}