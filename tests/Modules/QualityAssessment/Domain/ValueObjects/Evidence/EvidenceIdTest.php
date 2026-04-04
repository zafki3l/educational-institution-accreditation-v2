<?php

namespace Tests\Unit\Modules\QualityAssessment\Domain\ValueObjects\Evidence;

use App\Modules\QualityAssessment\Domain\ValueObjects\Evidence\EvidenceId;
use App\Modules\QualityAssessment\Domain\Exception\Evidence\EvidenceCodeInvalidException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class EvidenceIdTest extends TestCase
{
    public function testFromStringWithValidFormat(): void
    {
        $validCode = "H99.12.34.56";

        $evidenceId = EvidenceId::fromString($validCode);

        $this->assertEquals($validCode, $evidenceId->value());
    }

    #[DataProvider('invalidEvidenceCodeProvider')]
    public function testFromStringThrowsExceptionOnInvalidFormat(string $invalidCode): void
    {
        // Assert
        $this->expectException(EvidenceCodeInvalidException::class);

        // Act
        EvidenceId::fromString($invalidCode);
    }

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