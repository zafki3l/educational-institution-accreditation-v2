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
            ->with([
                'milestone.criteria.standard',
                'milestones.criteria.standard'
            ])
            ->orderByDesc('created_at');
        
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%");
            });
        }

        if (!empty($milestone_id)) {
            $query->where(function ($q) use ($milestone_id) {
                $q->where('milestone_id', $milestone_id)
                ->orWhereHas('milestones', function ($q2) use ($milestone_id) {
                    $q2->where('milestones.id', $milestone_id);
                });
            });
        }

        if (!empty($criteria_id)) {
            $query->where(function ($q) use ($criteria_id) {
                $q->whereHas('milestone', function ($q2) use ($criteria_id) {
                    $q2->where('criteria_id', $criteria_id);
                })
                ->orWhereHas('milestones', function ($q2) use ($criteria_id) {
                    $q2->where('criteria_id', $criteria_id);
                });
            });
        }

        if (!empty($standard_id)) {
            $query->where(function ($q) use ($standard_id) {
                $q->whereHas('milestone.criteria', function ($q2) use ($standard_id) {
                    $q2->where('standard_id', $standard_id);
                })
                ->orWhereHas('milestones.criteria', function ($q2) use ($standard_id) {
                    $q2->where('standard_id', $standard_id);
                });
            });
        }

        $paginator = $query->paginate(10, [
            'id',
            'name',
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