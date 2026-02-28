<?php

namespace App\Modules\QualityAssessment\Presentation\Requests\Evidence;

use App\Modules\QualityAssessment\Application\Requests\Evidence\UpdateEvidenceRequestInterface;

final class UpdateEvidenceRequest implements UpdateEvidenceRequestInterface
{
    private string $id;
    private string $name;
    private string $document_number;
    private string $issued_date;
    private string $issuing_authority;
    private ?array $file;
    private string $milestone_id;

    public function __construct() 
    {
        $this->id = $_POST['id'];
        $this->name = $_POST['name'];
        $this->document_number = $_POST['document_number'];
        $this->issued_date = $_POST['issued_date'];
        $this->issuing_authority = $_POST['issuing_authority'];
        $this->file = $_FILES['file'];
        $this->milestone_id = $_POST['milestone_id'];
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
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

    public function getFile(): ?array
    {
        return $this->file;
    }

    public function getMilestoneId(): string
    {
        return $this->milestone_id;
    }
}
