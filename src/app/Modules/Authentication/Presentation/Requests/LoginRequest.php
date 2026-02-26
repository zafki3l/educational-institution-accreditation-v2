<?php

namespace App\Modules\Authentication\Presentation\Requests;

use App\Modules\Authentication\Application\Requests\LoginRequestInterface;

final class LoginRequest implements LoginRequestInterface
{
    private string $identifier;
    private string $password;

    public function __construct()
    {
        $this->identifier = $_POST['identifier'];
        $this->password = $_POST['password'];
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
