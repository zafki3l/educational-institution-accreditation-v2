<?php

namespace App\Modules\UserManagement\Presentation\Controllers;

use App\Modules\Authorization\Application\Readers\RoleReaderInterface;
use App\Modules\DepartmentManagement\Application\Readers\DepartmentReaderInterface;
use App\Modules\UserManagement\Infrastructure\Readers\UserReader;
use App\Modules\UserManagement\Presentation\Requests\IndexUserRequest;
use App\Modules\UserManagement\Presentation\ViewModel\IndexUserViewModel;
use App\Shared\Web\Responses\ViewResponse;

final class IndexUserController extends UserController
{
    public function __construct(
        private UserReader $userReader,
        private RoleReaderInterface $roleReader,
        private DepartmentReaderInterface $departmentReader
    ) {}

    public function index(IndexUserRequest $request): ViewResponse
    {
        $roles = $this->roleReader->all();
        $departments = $this->departmentReader->all();
        
        $results = $this->userReader->all($request->getKeyword(), $request->getRoleId());

        $indexUserViewModel = array_map(fn ($user) => new IndexUserViewModel(
            $user->id,
            $user->first_name,
            $user->last_name,
            $user->email,
            $user->role_name,
            $user->department_name
        ), $results->items);

        return new ViewResponse(
            self::MODULE_NAME, 
            'index/main', 
            'main.layouts',
            [
                'title' => 'Quản lý người dùng | ' . SYSTEM_NAME,
                'users' => $indexUserViewModel,
                'pagination' => $results,
                'roles' => $roles,
                'departments' => $departments
            ]
        );
    }
}