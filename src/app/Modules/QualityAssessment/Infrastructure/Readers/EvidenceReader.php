<?php

namespace App\Modules\QualityAssessment\Infrastructure\Readers;

use App\Modules\QualityAssessment\Infrastructure\Models\Evidence;
use App\Modules\QualityAssessment\Presentation\Requests\Evidence\SearchEvidenceRequest;
use App\Shared\Application\DTOs\Paginator\PaginatedResultDTO;

class EvidenceReader
{
    public function getSearchResult(SearchEvidenceRequest $request): PaginatedResultDTO
    {
        $keyword = $request->getKeyword();
        $standard_id = $request->getStandardId();
        $criteria_id = $request->getCriteriaId();
        $milestone_id = $request->getMilestoneId();

        $query = Evidence::query()
                        ->with('milestone.criteria.standard')
                        ->orderByDesc('created_at');
        
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%");
            });
        }

        if (!empty($milestone_id)) {
            $query->where('milestone_id', $milestone_id);
        }

        if (!empty($criteria_id)) {
            $query->whereHas('milestone', function ($q) use ($criteria_id) {
                $q->where('criteria_id', $criteria_id);
            });
        }

        if (!empty($standard_id)) {
            $query->whereHas('milestone.criteria', function ($q) use ($standard_id) {
                $q->where('standard_id', $standard_id);
            });
        }

        $paginator = $query->paginate(10, [
            'id',
            'name',
            'milestone_id',
            'document_number',
            'issued_date',
            'issuing_authority',
            'file_url'
        ]);

        $items = $paginator->getCollection()->toArray();

        return new PaginatedResultDTO(
            $items,
            $paginator->currentPage(),
            $paginator->perPage(),
            $paginator->total(),
            $paginator->lastPage()
        );
    }
}