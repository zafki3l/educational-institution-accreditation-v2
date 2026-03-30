<?php

namespace App\Modules\Report\Presentation\Controllers;

use App\Modules\Report\Application\Readers\ReportReaderInterface;
use App\Shared\Web\Responses\JsonResponse;

final class EvidenceWithoutFileController extends ReportController
{
    public function __construct(private ReportReaderInterface $reportReader) {}

    public function getTotal(): JsonResponse
    {
        $data = $this->reportReader->totalWithoutFile();

        return new JsonResponse([
            'evidences' => $data->evidences,
            'total' => $data->count
        ]);
    }
}