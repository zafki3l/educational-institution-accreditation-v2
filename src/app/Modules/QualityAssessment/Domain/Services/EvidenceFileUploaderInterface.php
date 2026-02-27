<?php

namespace App\Modules\QualityAssessment\Domain\Services;

interface EvidenceFileUploaderInterface
{
    public function upload(array $file, string $evidence_id): string;
}