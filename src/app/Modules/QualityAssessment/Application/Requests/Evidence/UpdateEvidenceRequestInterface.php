<?php

namespace App\Modules\QualityAssessment\Application\Requests\Evidence;

interface UpdateEvidenceRequestInterface
{
    public function getId(): string;

    public function getName(): string;

    public function getDocumentNumber(): string;

    public function getIssuedDate(): string;

    public function getIssuingAuthority(): string;

    public function getFile(): ?array;

    public function getMilestoneId(): string;
}