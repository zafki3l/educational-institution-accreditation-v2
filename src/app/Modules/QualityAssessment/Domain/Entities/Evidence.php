<?php

namespace App\Modules\QualityAssessment\Domain\Entities;

use App\Modules\QualityAssessment\Domain\Exception\Evidence\EvidenceEmptyIdException;
use App\Modules\QualityAssessment\Domain\Exception\Evidence\EvidenceEmptyNameException;
use App\Modules\QualityAssessment\Domain\Exception\Evidence\EvidenceEmptyIssuingAuthorityException;
use App\Modules\QualityAssessment\Domain\Exception\Evidence\EvidenceEmptyFileUrlException;
use App\Modules\QualityAssessment\Domain\Exception\Milestone\MilestoneIdEmptyException;
use App\Modules\QualityAssessment\Domain\ValueObjects\Evidence\EvidenceId;
use DateTimeImmutable;

class Evidence
{
    private array $changes = [];

    private function __construct(
        private EvidenceId $id,
        private string $name,
        private ?string $document_number,
        private ?DateTimeImmutable $issued_date,
        private string $issuing_authority,
        private ?string $file_url,
        private int $milestone_id
    ) {}

    public static function create(
        EvidenceId $id,
        string $name,
        ?string $document_number,
        ?DateTimeImmutable $issued_date,
        string $issuing_authority,
        int $milestone_id
    ): self {
        self::checkIdEmpty($id);

        self::checkNameEmpty($name);

        self::checkMilestoneIdEmpty($milestone_id);

        self::checkIssuingAuthorityEmpty($issuing_authority);

        return new self($id, $name, $document_number, $issued_date, $issuing_authority, null, $milestone_id);
    }

    public function update(
        string $name,
        ?string $document_number,
        ?DateTimeImmutable $issued_date,
        string $issuing_authority,
        int $milestone_id,
        ?string $file_url
    ): void {
        self::checkNameEmpty($name);

        if ($this->name !== $name) {
            $this->changes['name'] = [
                'old' => $this->name,
                'new' => $name
            ];

            $this->name = $name;
        }

        if ($this->document_number !== $document_number) {
            $this->changes['document_number'] = [
                'old' => $this->document_number,
                'new' => $document_number
            ];

            $this->document_number = $document_number;
        }

        $old_issued_date = $this->issued_date?->format('Y-m-d');
        $new_issued_date = $issued_date?->format('Y-m-d');

        if ($old_issued_date !== $new_issued_date) {
            $this->changes['issued_date'] = [
                'old' => $this->issued_date,
                'new' => $issued_date
            ];
            $this->issued_date = $issued_date;
        }

        self::checkIssuingAuthorityEmpty($issuing_authority);

        if ($this->issuing_authority !== $issuing_authority) {
            $this->changes['issuing_authority'] = [
                'old' => $this->issuing_authority,
                'new' => $issuing_authority
            ];

            $this->issuing_authority = $issuing_authority;
        }

        self::checkMilestoneIdEmpty($milestone_id);

        if ($this->milestone_id !== $milestone_id) {
            $this->changes['milestone_id'] = [
                'old' => $this->milestone_id,
                'new' => $milestone_id
            ];

            $this->milestone_id = $milestone_id;
        }

        if ($this->file_url !== $file_url) {
            $this->changes['file_url'] = [
                'old' => $this->file_url,
                'new' => $file_url
            ];

            $this->file_url = $file_url;
        }
    }

    public function getId(): EvidenceId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDocumentNumber(): ?string
    {
        return $this->document_number;
    }

    public function getIssuedDate(): ?DateTimeImmutable
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

    public function getMilestoneId(): int
    {
        return $this->milestone_id;
    }

    public function getChanges(): array
    {
        return $this->changes;
    }

    public function hasChanges(): bool
    {
        return !empty($this->changes);
    }

    public function changeFileUrl(string $file_url): void
    {
        self::checkFileUrlEmpty($file_url);
        
        $this->file_url = $file_url;
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

    private static function checkMilestoneIdEmpty(int $milestone_id): void
    {
        if ($milestone_id === null || $milestone_id === 0) {
            throw new MilestoneIdEmptyException();
        }
    }
}