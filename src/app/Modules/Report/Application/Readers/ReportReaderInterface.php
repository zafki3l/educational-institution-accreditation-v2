<?php

namespace App\Modules\Report\Application\Readers;

use App\Modules\Report\Application\Responses\TotalEvidenceWithoutFileResponse;

interface ReportReaderInterface
{
    public function totalWithoutFile(): TotalEvidenceWithoutFileResponse;
}