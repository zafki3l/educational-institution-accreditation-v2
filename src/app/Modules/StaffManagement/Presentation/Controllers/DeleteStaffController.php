<?php

namespace App\Modules\StaffManagement\Presentation\Controllers;

use App\Modules\UserManagement\Application\UseCases\DeleteUserUseCase;
use App\Shared\SessionManager\AuthSession;

final class DeleteStaffController extends StaffController
{
    public function __construct(private DeleteUserUseCase $deleteUserUseCase) {}

    public function destroy(string $id)
    {
        $this->deleteUserUseCase->execute($id, AuthSession::getUserId());

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode([]);
            exit;
        }

        $this->redirect('/staffs?success=delete');
    }
}
