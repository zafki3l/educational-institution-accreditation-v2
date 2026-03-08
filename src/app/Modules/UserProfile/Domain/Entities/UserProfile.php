<?php

namespace App\Modules\UserProfile\Domain\Entities;

use App\Modules\UserProfile\Domain\Exceptions\InvalidEmailFormatException;
use App\Modules\UserProfile\Domain\Exceptions\UserIdEmptyException;
use App\Modules\UserProfile\Domain\Exceptions\UserNameEmptyException;

class UserProfile
{
    private function __construct(
        private string $id,
        private string $first_name,
        private string $last_name,
        private ?string $email,
        private ?string $password
    ) {}

    public static function create(
        string $id,
        string $first_name,
        string $last_name
    ): self {
        if ($id === '') {
            throw new UserIdEmptyException();
        }

        if ($first_name === '' && $last_name === '') {
            throw new UserNameEmptyException();
        }

        return new self($id, $first_name, $last_name, null, null);
    }

    public static function fromPersistent(
        string $id,
        string $first_name,
        string $last_name,
        ?string $email,
        ?string $password
    ) {
        return new self($id, $first_name, $last_name, $email, $password);
    }

    public function getId(): string
    {
        return $this->id;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function updateEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailFormatException();
        }

        $this->email = $email;
    }

    public function changePassword(string $password): void
    {
        $this->password = $password;
    }
}
