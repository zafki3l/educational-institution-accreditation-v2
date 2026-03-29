<?php

namespace App\Modules\DepartmentManagement\Domain\Entities;

use App\Modules\DepartmentManagement\Domain\Exception\EmptyDepartmentIdException;
use App\Modules\DepartmentManagement\Domain\Exception\EmptyDepartmentNameException;

class Department
{
    private array $changes = [];

    private function __construct(
        private string $id,
        private string $name
    ) {}

    public static function create(string $id, string $name): self
    {
        if (empty($id)) {
            throw new EmptyDepartmentIdException();
        }

        if (empty($name)) {
            throw new EmptyDepartmentNameException();
        }

        return new self($id, $name);
    }

    public function update(string $name): void
    {
        if (empty($name)) {
            throw new EmptyDepartmentNameException();
        }

        if ($this->name !== $name) {
            $this->changes['name'] = [
                'old' => $this->name, 
                'new' => $name
            ];

            $this->name = $name;
        }
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getChanges(): array
    {
        return $this->changes;
    }
}
