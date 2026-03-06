<?php

namespace Tests\Unit\Modules\QualityAssessment\Domain\Entities;

use App\Modules\QualityAssessment\Domain\Entities\Criteria;
use App\Modules\QualityAssessment\Domain\Exception\Criteria\CriteriaEmptyIdException;
use App\Modules\QualityAssessment\Domain\Exception\Criteria\CriteriaEmptyNameException;
use App\Modules\QualityAssessment\Domain\Exception\Criteria\CriteriaIdInvalidFormatException;
use App\Modules\QualityAssessment\Domain\Exception\Standard\StandardEmptyIdException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

final class CriteriaTest extends TestCase
{
    /**
     * Run: composer test -- --filter CriteriaTest::testCreateCriteriaSuccessfully
     * 
     * @return void
     */
    public function testCreateCriteriaSuccessfully(): void
    {
        $id = '1.5';
        $standardId = '1';
        $name = 'Tiêu chí về chất lượng đào tạo';

        $criteria = Criteria::create($id, $standardId, $name);

        $this->assertInstanceOf(Criteria::class, $criteria);
        $this->assertEquals($id, $criteria->getId());
        $this->assertEquals($name, $criteria->getName());
    }

    /**
     * Run: composer test -- --filter CriteriaTest::testUpdateCriteriaSuccessfully
     * 
     * @return void
     */
    public function testUpdateCriteriaSuccessfully(): void
    {
        $criteria = Criteria::create('1.1', '1', 'Tên cũ');
        
        $newStandardId = '1';
        $newName = 'Tên mới đã cập nhật';

        $criteria->update($newStandardId, $newName);

        $this->assertEquals($newName, $criteria->getName());
        $this->assertEquals($newStandardId, $criteria->getStandardId());
    }

    /**
     * Run: composer test -- --filter CriteriaTest::testCreateThrowsExceptionWhenIdFormatIsInvalid
     * 
     * @return void
     */
    #[DataProvider('invalidFormatProvider')]
    public function testCreateThrowsExceptionWhenIdFormatIsInvalid(string $id, string $standardId): void
    {
        $this->expectException(CriteriaIdInvalidFormatException::class);
        Criteria::create($id, $standardId, 'Tên tiêu chí');
    }

    public static function invalidFormatProvider(): array
    {
        return [
            'sai_standard_id' => ['2.1', '1'],
            'thieu_dau_cham' => ['11', '1'],
            'so_thu_tu_la_0' => ['1.0', '1'],
            'co_chu_cai' => ['1.a', '1'],
            'sai_hoan_toan' => ['abc.def', 'abc']
        ];
    }

    /**
     * Run: composer test -- --filter CriteriaTest::testCreateThrowsExceptionWhenDataIsEmpty
     * 
     * @return void
     */
    #[DataProvider('emptyDataProvider')]
    public function testCreateThrowsExceptionWhenDataIsEmpty(string $id, string $standardId, string $name, string $expectedException): void
    {
        $this->expectException($expectedException);
        Criteria::create($id, $standardId, $name);
    }

    public static function emptyDataProvider(): array
    {
        return [
            'id_trong' => ['', '1', 'Name', CriteriaEmptyIdException::class],
            'standard_id_trong' => ['1.1', '', 'Name', StandardEmptyIdException::class],
            'name_trong' => ['1.1', '1', '', CriteriaEmptyNameException::class],
        ];
    }
}