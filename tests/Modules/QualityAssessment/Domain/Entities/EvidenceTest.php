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
        $name = 'Initial Name';
        $docNumber = '123/QD';
        $issuedDate = new DateTimeImmutable('2023-01-01');
        $authority = 'Authority';
        $milestoneId = 10;

        $evidence = Evidence::create($id, $name, $docNumber, $issuedDate, $authority, $milestoneId);

        $this->assertInstanceOf(Evidence::class, $evidence);
        $this->assertEquals($name, $evidence->getName());
        $this->assertFalse($evidence->hasChanges(), 'New evidence should not have changes initially');
    }

    #[DataProvider('invalidEvidenceDataProvider')]
    public function testCreateThrowsExceptionWhenRequiredFieldsAreInvalid(
        string $name,
        ?string $docNumber,
        string $authority,
        int $milestoneId,
        string $expectedException
    ): void {
        $id = EvidenceId::fromString('H1.01.01.01');
        $issuedDate = new DateTimeImmutable();

        $this->expectException($expectedException);

        Evidence::create($id, $name, $docNumber, $issuedDate, $authority, $milestoneId);
    }

    public function testUpdateSuccessfullyTracksChanges(): void
    {
        $oldDate = new DateTimeImmutable('2023-01-01');
        $evidence = Evidence::create(
            EvidenceId::fromString('H1.01.01.01'),
            'Old Name',
            'Old Doc',
            $oldDate,
            'Old Authority',
            1
        );

        $newName = 'New Name';
        $newDate = new DateTimeImmutable('2024-01-01');
        $evidence->update(
            $newName,
            'Old Doc',
            $newDate,
            'Old Authority',
            2,
            'http://new-file.com'
        );

        $this->assertEquals($newName, $evidence->getName());
        $this->assertEquals(2, $evidence->getMilestoneId());
        $this->assertTrue($evidence->hasChanges());

        $changes = $evidence->getChanges();
        
        $this->assertArrayHasKey('name', $changes);
        $this->assertEquals('Old Name', $changes['name']['old']);
        $this->assertEquals('New Name', $changes['name']['new']);

        $this->assertArrayHasKey('milestone_id', $changes);
        $this->assertEquals(1, $changes['milestone_id']['old']);
        $this->assertEquals(2, $changes['milestone_id']['new']);

        $this->assertArrayNotHasKey('document_number', $changes);
        $this->assertArrayNotHasKey('issuing_authority', $changes);
    }

    public function testUpdateDateComparisonLogic(): void
    {
        $date = new DateTimeImmutable('2023-01-01');
        $id = EvidenceId::fromString('H1.01.01.01');
        
        $evidence = Evidence::create($id, 'Name', 'Doc', $date, 'Auth', 1);
        
        $this->assertFalse($evidence->hasChanges(), 'Should have no changes after creation');

        $sameDateValue = new DateTimeImmutable('2023-01-01');
        $evidence->update('Name', 'Doc', $sameDateValue, 'Auth', 1, null);

        $this->assertArrayNotHasKey(
            'issued_date', 
            $evidence->getChanges(), 
            'Updating with the same date value should not trigger a change'
        );
    }

    public function testUpdateThrowsExceptionWhenNameIsEmpty(): void
    {
        $evidence = $this->createValidEvidence();

        $this->expectException(EvidenceEmptyNameException::class);

        $evidence->update('', 'Doc', null, 'Auth', 1, null);
    }

    ## --- File URL Tests ---

    public function testChangeFileUrlSuccessfully(): void
    {
        $evidence = $this->createValidEvidence();
        $newUrl = 'new_file.pdf';

        $evidence->changeFileUrl($newUrl);

        $this->assertEquals($newUrl, $evidence->getFileUrl());
    }

    public function testChangeFileUrlThrowsExceptionWhenEmpty(): void
    {
        $evidence = $this->createValidEvidence();

        $this->expectException(EvidenceEmptyFileUrlException::class);

        $evidence->changeFileUrl('');
    }

    public static function invalidEvidenceDataProvider(): array
    {
        return [
            'empty_name' => ['', 'DOC-123', 'Authority', 1, EvidenceEmptyNameException::class],
            'empty_issuing_authority' => ['Name', 'DOC-123', '', 1, EvidenceEmptyIssuingAuthorityException::class],
            'milestone_id_is_zero' => ['Name', 'DOC-123', 'Authority', 0, MilestoneIdEmptyException::class],
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