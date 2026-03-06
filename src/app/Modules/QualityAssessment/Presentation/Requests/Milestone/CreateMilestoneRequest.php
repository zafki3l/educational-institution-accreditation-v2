<?php

namespace App\Modules\QualityAssessment\Presentation\Requests\Milestone;

use App\Modules\QualityAssessment\Application\Requests\Milestone\CreateMilestoneRequestInterface;

final class CreateMilestoneRequest implements CreateMilestoneRequestInterface
{
    private int $order;
    private string $criteria_id;
    private string $name;

    public function __construct()
    {
        $this->order = (int) trim($_POST['order']);
        $this->criteria_id = trim($_POST['criteria_id']);
        $this->name = trim($_POST['name']);
    }

    public function getOrder(): int
    {
        return $this->order;
    }

    public function getCriteriaId(): string
    {
        return $this->criteria_id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
