<?php

namespace App\Modules\UserProfile\Presentation\Requests;

use App\Modules\UserProfile\Application\Requests\UpdateUserProfileRequestInterface;

final class UpdateUserProfileRequest implements UpdateUserProfileRequestInterface
{
    private string $first_name;
    private string $last_name;
    private ?string $email;

    public function __construct()
    {
        $this->first_name = $_POST['first_name'];
        $this->last_name = $_POST['last_name'];
        $this->email = $_POST['email'] ? trim(strtolower($_POST['email'])) : '';
    }

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }
}
