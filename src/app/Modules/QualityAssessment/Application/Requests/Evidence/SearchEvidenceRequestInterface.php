<?php

namespace App\Modules\QualityAssessment\Application\Requests\Evidence;

interface SearchEvidenceRequestInterface
{
    public function getKeyword(): string;

    public function getStandardId(): string;

    public function getCriteriaId(): string;

    public function getMilestoneId(): ?int;
}