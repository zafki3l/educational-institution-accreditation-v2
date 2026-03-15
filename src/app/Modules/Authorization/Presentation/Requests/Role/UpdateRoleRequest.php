<?php

namespace App\Modules\Authorization\Presentation\Requests\Role;

use App\Modules\Authorization\Application\Role\Requests\UpdateRoleRequestInterface;

final class UpdateRoleRequest implements UpdateRoleRequestInterface
{
    private int $id;
    private string $name;

    public function __construct()
    {
        $this->id = (int) ($_POST['id'] ?? 0);
        $this->name = trim($_POST['name'] ?? '');
    }

    public function getId(): int { return $this->id; }

    public function getName(): string { return $this->name; }
}
