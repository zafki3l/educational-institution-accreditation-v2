<?php

namespace Tests\Unit\Modules\QualityAssessment\Domain\Entities;

use App\Modules\QualityAssessment\Domain\Entities\Milestone;
use App\Modules\QualityAssessment\Domain\ValueObjects\Milestone\MilestoneCode;
use App\Modules\QualityAssessment\Domain\Exception\Criteria\CriteriaEmptyIdException;
use App\Modules\QualityAssessment\Domain\Exception\Milestone\MilestoneNameEmptyException;
use App\Modules\QualityAssessment\Domain\Exception\Milestone\MilestoneOrderInvalidException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

final class MilestoneTest extends TestCase
{
    /**
     * Run: composer test -- --filter MilestoneTest::testCreateMilestoneSuccessfully
     * 
     * @return void
     */
    public function testCreateMilestoneSuccessfully(): void
    {
        $id = 100;
        $criteriaId = "1.1";
        $code = MilestoneCode::fromString("1.1.1");
        $order = 1;
        $name = "Mốc đánh giá số 1";

        $milestone = Milestone::create($id, $criteriaId, $code, $order, $name);

        $this->assertInstanceOf(Milestone::class, $milestone);
        $this->assertEquals($id, $milestone->getId());
        $this->assertEquals($criteriaId, $milestone->getCriteriaId());
        $this->assertSame($code, $milestone->getCode());
        $this->assertEquals($order, $milestone->getOrder());
        $this->assertEquals($name, $milestone->getName());
    }

    /**
     * Run: composer test -- --filter MilestoneTest::testCreateThrowsExceptionWhenNameIsEmpty
     * 
     * @return void
     */
    public function testCreateThrowsExceptionWhenNameIsEmpty(): void
    {
        $this->expectException(MilestoneNameEmptyException::class);

        Milestone::create(
            null, 
            '1.1', 
            MilestoneCode::fromString('1.1.1'), 
            1, 
            ''
        );
    }

    /**
     * Run: composer test -- --filter MilestoneTest::testCreateThrowsExceptionWhenCriteriaIdIsEmpty
     * 
     * @return void
     */
    public function testCreateThrowsExceptionWhenCriteriaIdIsEmpty(): void
    {
        $this->expectException(CriteriaEmptyIdException::class);

        Milestone::create(
            null, 
            '', 
            MilestoneCode::fromString('1.1.1'), 
            1, 
            'Valid Name'
        );
    }

    /**
     * Run: composer test -- --filter MilestoneTest::testCreateThrowsExceptionWhenOrderIsInvalid
     * 
     * @return void
     */
    #[DataProvider('invalidOrderProvider')]
    public function testCreateThrowsExceptionWhenOrderIsInvalid(int $invalidOrder): void
    {
        $this->expectException(MilestoneOrderInvalidException::class);

        Milestone::create(
            null, 
            '1.1', 
            MilestoneCode::fromString('1.1.1'), 
            $invalidOrder, 
            'Valid Name'
        );
    }

    public static function invalidOrderProvider(): array
    {
        return [
            'order_bang_0' => [0],
            'order_so_am' => [-1],
            'order_am_sau' => [-99],
        ];
    }
}