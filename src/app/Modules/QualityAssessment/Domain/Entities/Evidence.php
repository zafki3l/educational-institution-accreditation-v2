<?php

namespace App\Modules\QualityAssessment\Domain\Entities;

use App\Modules\QualityAssessment\Domain\Exception\Evidence\EvidenceEmptyIdException;
use App\Modules\QualityAssessment\Domain\Exception\Evidence\EvidenceEmptyNameException;
use App\Modules\QualityAssessment\Domain\Exception\Evidence\EvidenceEmptyDocumentNumberException;
use App\Modules\QualityAssessment\Domain\Exception\Evidence\EvidenceEmptyIssuedDateException;
use App\Modules\QualityAssessment\Domain\Exception\Evidence\EvidenceEmptyIssuingAuthorityException;
use App\Modules\QualityAssessment\Domain\Exception\Evidence\EvidenceEmptyFileUrlException;
use App\Modules\QualityAssessment\Domain\ValueObjects\Evidence\EvidenceId;
use DateTimeImmutable;

class Evidence
{
    private function __construct(
        private EvidenceId $id,
        private string $name,
        private string $document_number,
        private DateTimeImmutable $issued_date,
        private string $issuing_authority,
        private ?string $file_url,
        private string $milestone_id
    ) {}

    public static function create(
        EvidenceId $id,
        string $name,
        string $document_number,
        DateTimeImmutable $issued_date,
        string $issuing_authority,
        string $milestone_id
    ): self {
        self::checkIdEmpty($id);

        self::checkNameEmpty($name);

        self::checkDocumentNumberEmpty($document_number);

        self::checkIssuedDateEmpty($issued_date);

        self::checkIssuingAuthorityEmpty($issuing_authority);

        return new self($id, $name, $document_number, $issued_date, $issuing_authority, null, $milestone_id);
    }

    public function getId(): EvidenceId
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

    public function getIssuedDate(): DateTimeImmutable
    {
        return $this->issued_date;
    }

    public function getIssuingAuthority(): string
    {
        return $this->issuing_authority;
    }

    public function getFileUrl(): ?string
    {
        return $this->file_url;
    }

    public function getMilestoneId(): string
    {
        return $this->milestone_id;
    }

    public function changeFileUrl(string $file_url): void
    {
        self::checkFileUrlEmpty($file_url);
        
        $this->file_url = $file_url;
    }

    private static function checkDocumentNumberEmpty(string $document_number): void
    {
        if ($document_number === '') {
            throw new EvidenceEmptyDocumentNumberException();
        }
    }

    private static function checkIssuedDateEmpty(DateTimeImmutable $issued_date): void
    {
        if ($issued_date->format('Y-m-d') === '') {
            throw new EvidenceEmptyIssuedDateException();
        }
    }

    private static function checkIssuingAuthorityEmpty(string $issuing_authority): void
    {
        if ($issuing_authority === '') {
            throw new EvidenceEmptyIssuingAuthorityException();
        }
    }

    private static function checkFileUrlEmpty(string $file_url): void
    {
        if ($file_url === '') {
            throw new EvidenceEmptyFileUrlException();
        }
    }

    private static function checkNameEmpty(string $name): void
    {
        if ($name === '') {
            throw new EvidenceEmptyNameException();
        }
    }

    private static function checkIdEmpty(EvidenceId $id): void
    {
        if ($id->value() === '') {
            throw new EvidenceEmptyIdException();
        }
    }
}