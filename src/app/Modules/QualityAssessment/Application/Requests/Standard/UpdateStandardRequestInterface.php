<?php

namespace App\Modules\QualityAssessment\Application\Requests\Standard;

interface UpdateStandardRequestInterface
{
    public function getId(): string;

    public function getName(): string;

    public function getDepartmentId(): string;
}