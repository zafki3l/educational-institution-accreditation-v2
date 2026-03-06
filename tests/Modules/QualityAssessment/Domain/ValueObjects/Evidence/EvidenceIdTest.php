<?php

namespace Tests\Unit\Modules\QualityAssessment\Domain\ValueObjects\Evidence;

use App\Modules\QualityAssessment\Domain\ValueObjects\Evidence\EvidenceId;
use App\Modules\QualityAssessment\Domain\Exception\Evidence\EvidenceCodeInvalidException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class EvidenceIdTest extends TestCase
{
    /**
     * Run: composer test -- --filter EvidenceIdTest::testGenerateReturnsFormattedCodeWithPadding
     * 
     * @return void
     */
    public function testGenerateReturnsFormattedCodeWithPadding(): void
    {
        $box = 1;
        $standard = 2;
        $criteria = 3;
        $evidence = 4;

        $evidenceId = EvidenceId::generate($box, $standard, $criteria, $evidence);

        $this->assertEquals('H1.02.03.04', $evidenceId->value());
    }

    /**
     * Run: composer test -- --filter EvidenceIdTest::testFromStringWithValidFormat
     * 
     * @return void
     */
    public function testFromStringWithValidFormat(): void
    {
        $validCode = "H99.12.34.56";

        $evidenceId = EvidenceId::fromString($validCode);

        $this->assertEquals($validCode, $evidenceId->value());
    }

    /**
     * Run: composer test -- --filter EvidenceIdTest::testFromStringThrowsExceptionOnInvalidFormat
     * 
     * @return void
     */
    #[DataProvider('invalidEvidenceCodeProvider')]
    public function testFromStringThrowsExceptionOnInvalidFormat(string $invalidCode): void
    {
        // Assert
        $this->expectException(EvidenceCodeInvalidException::class);

        // Act
        EvidenceId::fromString($invalidCode);
    }

    /**
     * Run: composer test -- --filter EvidenceIdTest::testIsValidHelperMethod
     * 
     * @return void
     */
    public function testIsValidHelperMethod(): void
    {
        $this->assertTrue(EvidenceId::isValid('H1.01.01.01'));
        $this->assertFalse(EvidenceId::isValid('A1.01.01.01')); 
        $this->assertFalse(EvidenceId::isValid('H1.1.1.1')); 
    }

    public static function invalidEvidenceCodeProvider(): array
    {
        return [
            'sai_chu_dau'   => ['A1.01.01.01'],
            'thieu_so_0'    => ['H1.1.01.01'], 
            'thua_nhom_so'  => ['H1.01.01.01.01'],
            'chua_chu_cai'  => ['H1.01.AA.01'],
            'khong_dau_dot' => ['H1010101'],
            'so_am'         => ['H-1.01.01.01'],
        ];
    }
}