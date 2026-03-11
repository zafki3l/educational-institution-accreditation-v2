<?php

namespace App\Modules\Authentication\Presentation\Controllers;

use App\Modules\Authentication\Application\UseCases\LoginUseCase;
use App\Modules\Authentication\Presentation\Requests\LoginRequest;
use App\Shared\Response\ViewResponse;
use App\Shared\SessionManager\AuthSession;

final class LoginController extends AuthController
{
    public function __construct(private LoginUseCase $loginUseCase) {}

    public function showLogin(): ViewResponse
    {
        return new ViewResponse(
            self::MODULE_NAME,
            'login/main',
            'login.layouts',
            [
                'title' => 'Đăng nhập | ' . SYSTEM_NAME
            ]
        );
    }

    public function login(LoginRequest $request): void
    {
        $auth_user = $this->loginUseCase->execute($request);

        if (!$auth_user) {
            $_SESSION['login_errors'] = 'Tài khoản hoặc mật khẩu không hợp lệ!';

            $this->redirect(HOST . '/login');
        }

        session_regenerate_id(true);

        AuthSession::set([
            'user_id' => $auth_user->getUserId()->value(),
            'identifier' => $auth_user->getIdentifier(),
            'role_id' => $auth_user->getRoleId()
        ]);

        if (isAdmin()) {
            $this->redirect('/admin/dashboard');
        } else if (isStaff()) {
            $this->redirect('/staff/dashboard');
        } else {
            $this->redirect('/');
        }
    }
}