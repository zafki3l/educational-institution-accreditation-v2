<?php

namespace App\Modules\Authorization\Presentation\Controllers;

use App\Modules\Authorization\Application\Readers\RoleReaderInterface;
use App\Modules\Authorization\Application\Responses\RoleReaderResponse;
use App\Modules\Authorization\Presentation\ViewModels\IndexRoleViewModel;
use App\Shared\Web\Responses\ViewResponse;

final class IndexRoleController extends AuthorizationController
{
    public function __construct(private RoleReaderInterface $roleReader) {}

    public function index(): ViewResponse
    {
        $roles = array_map(
            fn (RoleReaderResponse $role) => new IndexRoleViewModel($role->id, $role->name), 
            $this->roleReader->all()
        );

        return new ViewResponse(
            self::MODULE_NAME,
            'index', 
            'main.layouts', 
            [
                'title' => 'Cập nhật vai trò | ' . SYSTEM_NAME,
                'roles' => $roles
            ]
        );
    }
}