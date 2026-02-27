<?php

namespace App\Modules\QualityAssessment\Application\Requests\Evidence;

interface CreateEvidenceRequestInterface
{
    public function getId(): string;

    public function getName(): string;

    public function getCriteriaId(): string;

    public function getMilestoneId(): int;

    public function getDocumentNumber(): string;

    public function getIssuedDate(): string;

    public function getIssuingAuthority(): string;

    public function getFile(): ?array;
}