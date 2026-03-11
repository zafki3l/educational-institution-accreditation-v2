<?php

namespace App\Modules\DepartmentManagement\Presentation\Requests;

use App\Modules\DepartmentManagement\Application\Requests\UpdateDepartmentRequestInterface;

final class UpdateDepartmentRequest implements UpdateDepartmentRequestInterface
{
    private string $name;

    public function __construct()
    {
        $this->name = trim($_POST['name'] ?? '');
    }

    public function getName(): string
    {
        return $this->name;
    }
}
