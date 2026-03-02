<?php

namespace App\Modules\Authorization\Domain\Entities;

use App\Modules\Authorization\Domain\Exception\EmptyRoleNameException;

class Role
{
    public const ROLE_ADMIN = 3;
    public const ROLE_STAFF = 2;
    
    private ?int $id;

    private function __construct(
        ?int $id,
        private string $name
    ) {
        $this->id = $id;
    }

    public static function create(string $name): self
    {
        if (empty($name)) {
            throw new EmptyRoleNameException();
        }

        return new self(null, $name);
    }

    public function assignId(int $id): void
    {
        if ($this->id !== null) {
            throw new EmptyRoleNameException();
        }

        $this->id = $id;
    }

    public function getId(): ?int { return $this->id; }

    public function getName(): string { return $this->name; }
}