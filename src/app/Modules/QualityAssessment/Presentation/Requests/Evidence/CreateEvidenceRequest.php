<?php

namespace App\Modules\QualityAssessment\Presentation\Requests\Evidence;

final class CreateEvidenceRequest
{
    private string $id;
    private string $name;
    private string $criteria_id;
    private ?int $milestone_id;
    private string $document_number;
    private string $issued_date;
    private string $issuing_authority;
    private array $file;

    public function __construct() 
    {
        $this->id = $_POST['id'];
        $this->name = $_POST['name'];
        $this->criteria_id = $_POST['criteria_id'];
        $this->milestone_id = $_POST['milestone_id'];
        $this->document_number = $_POST['document_number'];
        $this->issued_date = $_POST['issued_date'];
        $this->issuing_authority = $_POST['issuing_authority'];
        $this->file = $_FILES['file'];
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCriteriaId(): string
    {
        return $this->criteria_id;
    }

    public function getMilestoneId(): int
    {
        return $this->milestone_id;
    }

    public function getDocumentNumber(): string
    {
        return $this->document_number;
    }

    public function getIssuedDate(): string
    {
        return $this->issued_date;
    }

    public function getIssuingAuthority(): string
    {
        return $this->issuing_authority;
    }

    public function getFile(): array
    {
        return $this->file;
    }
}
