<?php

namespace App\Modules\Report\Presentation\Controllers;

use App\Modules\QualityAssessment\Infrastructure\Models\Evidence;
use App\Shared\Web\Responses\JsonResponse;

final class EvidenceWithoutFileController extends ReportController
{
    public function totalWithoutFile(): JsonResponse
    {
        $evidences = Evidence::where('file_url', null)->get();
        $total = $evidences->count();

        return new JsonResponse([
            'evidences' => $evidences,
            'total' => $total
        ]);
    }
}