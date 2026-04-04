<?php

namespace Tests\Unit\Modules\QualityAssessment\Domain\Entities;

use App\Modules\QualityAssessment\Domain\Entities\Evidence;
use App\Modules\QualityAssessment\Domain\Exception\Evidence\EvidenceEmptyFileUrlException;
use App\Modules\QualityAssessment\Domain\Exception\Evidence\EvidenceEmptyIssuingAuthorityException;
use App\Modules\QualityAssessment\Domain\Exception\Evidence\EvidenceEmptyNameException;
use App\Modules\QualityAssessment\Domain\Exception\Milestone\MilestoneIdEmptyException;
use App\Modules\QualityAssessment\Domain\ValueObjects\Evidence\EvidenceId;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class EvidenceTest extends TestCase
{
    public function testCreateEvidenceSuccessfully(): void
    {
        $id = EvidenceId::fromString('H1.01.01.01');
        $name = 'Decision to establish the council';
        $docNumber = '123/QD-UBND';
        $issuedDate = new DateTimeImmutable('2023-01-01');
        $authority = 'Provincial People Committee';
        $milestoneId = 10;

        $evidence = Evidence::create($id, $name, $docNumber, $issuedDate, $authority, $milestoneId);

        $this->assertInstanceOf(Evidence::class, $evidence);
        $this->assertSame($id, $evidence->getId());
        $this->assertEquals($name, $evidence->getName());
        $this->assertEquals($docNumber, $evidence->getDocumentNumber());
        $this->assertEquals($issuedDate, $evidence->getIssuedDate());
        $this->assertEquals($authority, $evidence->getIssuingAuthority());
        $this->assertEquals($milestoneId, $evidence->getMilestoneId());
        $this->assertNull($evidence->getFileUrl());
    }

    public function testChangeFileUrlSuccessfully(): void
    {
        $evidence = $this->createValidEvidence();
        $newUrl = 'file.pdf';

        $evidence->changeFileUrl($newUrl);

        $this->assertEquals($newUrl, $evidence->getFileUrl());
    }

    public function testChangeFileUrlThrowsExceptionWhenEmpty(): void
    {
        $evidence = $this->createValidEvidence();

        $this->expectException(EvidenceEmptyFileUrlException::class);

        $evidence->changeFileUrl('');
    }

    #[DataProvider('invalidEvidenceDataProvider')]
    public function testCreateThrowsExceptionWhenRequiredFieldsAreInvalid(
        string $name,
        string $docNumber,
        string $authority,
        int $milestoneId,
        string $expectedException
    ): void {
        $id = EvidenceId::fromString('H1.01.01.01');
        $issuedDate = new DateTimeImmutable();

        $this->expectException($expectedException);

        Evidence::create($id, $name, $docNumber, $issuedDate, $authority, $milestoneId);
    }

    public static function invalidEvidenceDataProvider(): array
    {
        return [
            'empty_name' => [
                '', 'DOC-123', 'Authority', 1, EvidenceEmptyNameException::class
            ],
            'empty_issuing_authority' => [
                'Evidence Name', 'DOC-123', '', 1, EvidenceEmptyIssuingAuthorityException::class
            ],
            'milestone_id_is_zero' => [
                'Evidence Name', 'DOC-123', 'Authority', 0, MilestoneIdEmptyException::class
            ],
        ];
    }
    
    private function createValidEvidence(): Evidence
    {
        return Evidence::create(
            EvidenceId::fromString('H1.01.01.01'),
            'Valid Name',
            '123',
            new DateTimeImmutable(),
            'Authority',
            1
        );
    }
}