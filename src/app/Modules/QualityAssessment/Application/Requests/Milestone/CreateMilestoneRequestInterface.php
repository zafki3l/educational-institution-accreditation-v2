<?php

namespace App\Modules\QualityAssessment\Application\Requests\Milestone;

interface CreateMilestoneRequestInterface
{
    public function getOrder(): int;

    public function getCriteriaId(): string;

    public function getName(): string;
}