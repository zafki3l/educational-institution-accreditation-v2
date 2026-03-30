<?php

namespace App\Modules\QualityAssessment\Presentation\Requests\Evidence;

use App\Modules\QualityAssessment\Application\Requests\Evidence\SearchEvidenceRequestInterface;

final class SearchEvidenceRequest implements SearchEvidenceRequestInterface
{
    private string $keyword;
    private string $standard_id;
    private string $criteria_id;
    private ?int $milestone_id;

    public function __construct()
    {
        $this->keyword = $_GET['keyword'] ?? '';
        $this->standard_id = $_GET['standard_id'] ?? '';
        $this->criteria_id = $_GET['criteria_id'] ?? '';
        $this->milestone_id = isset($_GET['milestone_id'])
                                ? (int) $_GET['milestone_id']
                                : null;
    }

    public function getKeyword(): string
    {
        return $this->keyword;
    }

    public function getStandardId(): string
    {
        return $this->standard_id;
    }

    public function getCriteriaId(): string
    {
        return $this->criteria_id;
    }

    public function getMilestoneId(): ?int
    {
        return $this->milestone_id;
    }
}
