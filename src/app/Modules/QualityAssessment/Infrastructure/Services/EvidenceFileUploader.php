<?php

namespace App\Modules\QualityAssessment\Infrastructure\Services;

use App\Modules\FileUpload\Application\UploadFileUseCase;
use App\Modules\QualityAssessment\Domain\Services\EvidenceFileUploaderInterface;

final class EvidenceFileUploader implements EvidenceFileUploaderInterface
{
    public function __construct(private UploadFileUseCase $uploadFileUseCase) {}

    public function upload(array $file, $evidence_id): string
    {
        return $this->uploadFileUseCase->execute($file, $evidence_id);
    }
}