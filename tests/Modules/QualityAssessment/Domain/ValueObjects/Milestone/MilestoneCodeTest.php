<?php

namespace Tests\Unit\Modules\QualityAssessment\Domain\ValueObjects\Milestone;

use App\Modules\QualityAssessment\Domain\ValueObjects\Milestone\MilestoneCode;
use App\Modules\QualityAssessment\Domain\Exception\Milestone\MilestoneCodeInvalidException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class MilestoneCodeTest extends TestCase
{
    /**
     * Run: composer test -- --filter MilestoneCodeTest::testGenerateReturnsCorrectFormattedString
     * 
     * @return void
     */
    public function testGenerateReturnsCorrectFormattedString(): void
    {
        $criteriaId = "1.2";
        $order = 3;

        $milestoneCode = MilestoneCode::generate($criteriaId, $order);

        $this->assertEquals("1.2.3", $milestoneCode->value());
    }

    /**
     * Run: composer test -- --filter MilestoneCodeTest::testFromStringWithValidFormat
     * 
     * @return void
     */
    public function testFromStringWithValidFormat(): void
    {
        $validCode = "10.20.30";

        $milestoneCode = MilestoneCode::fromString($validCode);

        $this->assertEquals("10.20.30", $milestoneCode->value());
    }

    /**
     * Run: composer test -- --filter MilestoneCodeTest::testFromStringThrowsExceptionOnInvalidFormat
     * 
     * @return void
     */
    #[DataProvider('invalidCodeProvider')]
    public function testFromStringThrowsExceptionOnInvalidFormat(string $invalidCode): void
    {
        // Assert
        $this->expectException(MilestoneCodeInvalidException::class);

        // Act
        MilestoneCode::fromString($invalidCode);
    }

    public static function invalidCodeProvider(): array
    {
        return [
            'thieu_dot'    => ['1.2'],
            'thua_dot'     => ['1.2.3.4'],
            'chua_chu'     => ['1.a.3'],
            'rong_o_giua'  => ['1..3'],
            'ky_tu_la'     => ['1.2.#'],
            'chuoi_rong'   => [''],
        ];
    }
}