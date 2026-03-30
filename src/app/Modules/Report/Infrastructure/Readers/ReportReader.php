<?php

namespace App\Modules\Report\Infrastructure\Readers;

use App\Modules\QualityAssessment\Infrastructure\Models\Evidence;
use App\Modules\Report\Application\Readers\ReportReaderInterface;
use App\Modules\Report\Application\Responses\TotalEvidenceWithoutFileResponse;

class ReportReader implements ReportReaderInterface
{    
    public function totalWithoutFile(): TotalEvidenceWithoutFileResponse
    {
        $evidences = Evidence::where('file_url', null)->get();
        $total = $evidences->count();

        return new TotalEvidenceWithoutFileResponse(
            $evidences->toArray(),
            $total
        );
    }
}