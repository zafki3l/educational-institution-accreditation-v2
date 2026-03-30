<?php

namespace App\Modules\QualityAssessment\Domain\Entities;

use App\Modules\QualityAssessment\Domain\Exception\Standard\StandardEmptyDepartmentIdException;
use App\Modules\QualityAssessment\Domain\Exception\Standard\StandardEmptyIdException;
use App\Modules\QualityAssessment\Domain\Exception\Standard\StandardEmptyNameException;
use App\Modules\QualityAssessment\Domain\Exception\Standard\StandardInvalidIdException;

class Standard
{
    private array $changes = [];

    private function __construct(
        private string $id,
        private string $name,
        private string $department_id
    ) {}

    public static function create(
        string $id,
        string $name,
        string $department_id
    ): self {
        if ($id === '') {
            throw new StandardEmptyIdException();
        }

        if (!ctype_digit($id) || (int) $id <= 0) {
            throw new StandardInvalidIdException();
        }

        if ($name === '') {
            throw new StandardEmptyNameException();
        }

        if ($department_id === '') {
            throw new StandardEmptyDepartmentIdException();
        }

        return new self($id, $name, $department_id);
    }

    public function update(
        string $name,
        string $department_id
    ): void {
        if ($this->name !== $name) {
            $this->changes['name'] = [
                'old' => $this->name,
                'new' => $name
            ];

            $this->name = $name;
        }

        if ($this->department_id !== $department_id) {
            $this->changes['department_id'] = [
                'old' => $this->department_id,
                'new' => $department_id
            ];

            $this->department_id = $department_id;
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

    public function getDepartmentId(): string
    {
        return $this->department_id;
    }

    public function getChanges(): array
    {
        return $this->changes;
    }

    public function hasChanges(): bool
    {
        return !empty($this->changes);
    }
}
