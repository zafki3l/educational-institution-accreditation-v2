<?php

namespace Tests\Unit\Modules\QualityAssessment\Domain\Entities;

use App\Modules\QualityAssessment\Domain\Entities\Evidence;
use App\Modules\QualityAssessment\Domain\Exception\Evidence\EvidenceEmptyDocumentNumberException;
use App\Modules\QualityAssessment\Domain\Exception\Evidence\EvidenceEmptyIssuingAuthorityException;
use App\Modules\QualityAssessment\Domain\Exception\Evidence\EvidenceEmptyNameException;
use App\Modules\QualityAssessment\Domain\Exception\Milestone\MilestoneIdEmptyException;
use App\Modules\QualityAssessment\Domain\ValueObjects\Evidence\EvidenceId;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class EvidenceTest extends TestCase
{
    /**
     * Run: composer test -- --filter EvidenceTest::testCreateEvidenceSuccessfully
     * 
     * @return void
     */
    public function testCreateEvidenceSuccessfully(): void
    {
        $id = EvidenceId::fromString('H1.01.01.01');
        $name = 'Quyết định thành lập hội đồng';
        $docNumber = '123/QĐ-UBND';
        $issuedDate = new DateTimeImmutable('2023-01-01');
        $authority = 'UBND Tỉnh';
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

    /**
     * Run: composer test -- --filter EvidenceTest::testChangeFileUrlSuccessfully
     * 
     * @return void
     */
    public function testChangeFileUrlSuccessfully(): void
    {
        $evidence = $this->createValidEvidence();
        $newUrl = 'file.pdf';

        $evidence->changeFileUrl($newUrl);

        $this->assertEquals($newUrl, $evidence->getFileUrl());
    }

    /**
     * Run: composer test -- --filter EvidenceTest::testCreateThrowsExceptionWhenFieldsAreEmpty
     * 
     * @return void
     */
    #[DataProvider('emptyFieldsProvider')]
    public function testCreateThrowsExceptionWhenFieldsAreEmpty(
        string $field, 
        mixed $value, 
        string $expectedException
    ): void {
        $data = [
            'id' => EvidenceId::fromString('H1.01.01.01'),
            'name' => 'Name',
            'doc' => '123',
            'date' => new DateTimeImmutable(),
            'auth' => 'Auth',
            'milestone' => 1
        ];

        $data[$field] = $value;

        $this->expectException($expectedException);

        Evidence::create(
            $data['id'],
            $data['name'],
            $data['doc'],
            $data['date'],
            $data['auth'],
            $data['milestone']
        );
    }

    public static function emptyFieldsProvider(): array
    {
        return [
            'ten_trong'        => ['name', '', EvidenceEmptyNameException::class],
            'so_hieu_trong'    => ['doc', '', EvidenceEmptyDocumentNumberException::class],
            'co_quan_trong'    => ['auth', '', EvidenceEmptyIssuingAuthorityException::class],
            'milestone_id_0'   => ['milestone', 0, MilestoneIdEmptyException::class],
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