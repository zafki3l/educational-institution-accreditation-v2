<?php

namespace App\Modules\QualityAssessment\Presentation\Requests\Standard;

use App\Modules\QualityAssessment\Application\Requests\Standard\UpdateStandardRequestInterface;

final class UpdateStandardRequest implements UpdateStandardRequestInterface
{
    private string $id;
    private string $name;
    private string $department_id;

    public function __construct()
    {
        $this->id = trim($_POST['id'] ?? '');
        $this->name = trim($_POST['name'] ?? '');
        $this->department_id = trim($_POST['department_id'] ?? '');
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
}