<?php

namespace Tests\Unit\Modules\QualityAssessment\Domain\ValueObjects\Milestone;

use App\Modules\QualityAssessment\Domain\ValueObjects\Milestone\MilestoneCode;
use App\Modules\QualityAssessment\Domain\Exception\Milestone\MilestoneCodeInvalidException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class MilestoneCodeTest extends TestCase
{
    public function testGenerateReturnsCorrectFormattedString(): void
    {
        $criteriaId = "1.2";
        $order = 3;

        $milestoneCode = MilestoneCode::generate($criteriaId, $order);

        $this->assertEquals("1.2.3", $milestoneCode->value());
    }

    public function testFromStringWithValidFormat(): void
    {
        $validCode = "10.20.30";

        $milestoneCode = MilestoneCode::fromString($validCode);

        $this->assertEquals("10.20.30", $milestoneCode->value());
    }

    #[DataProvider('invalidCodeProvider')]
    public function testFromStringThrowsExceptionOnInvalidFormat(string $invalidCode): void
    {
        $this->expectException(MilestoneCodeInvalidException::class);

        MilestoneCode::fromString($invalidCode);
    }

    public static function invalidCodeProvider(): array
    {
        return [
            'missing_last_dot' => ['1.2'],
            'too_many_dot' => ['1.2.3.4'],
            'contains_character' => ['1.a.3'],
            'empty_middle' => ['1..3'],
            'special_character' => ['1.2.#'],
            'empty_string' => [''],
        ];
    }
}