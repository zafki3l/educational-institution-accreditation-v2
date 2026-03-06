<?php

namespace Tests\Unit\Modules\QualityAssessment\Domain\Entities;

use App\Modules\QualityAssessment\Domain\Entities\Standard;
use App\Modules\QualityAssessment\Domain\Exception\Standard\StandardEmptyDepartmentIdException;
use App\Modules\QualityAssessment\Domain\Exception\Standard\StandardEmptyIdException;
use App\Modules\QualityAssessment\Domain\Exception\Standard\StandardEmptyNameException;
use App\Modules\QualityAssessment\Domain\Exception\Standard\StandardInvalidIdException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

final class StandardTest extends TestCase
{
    /**
     * Run: composer test -- --filter StandardTest::testCreateWithValidData
     * 
     * @return void
     */
    public function testCreateWithValidData(): void
    {
        $id = '1';
        $name = 'Tiêu chuẩn về cơ sở vật chất';
        $deptId = 'DEPT-001';

        $standard = Standard::create($id, $name, $deptId);

        $this->assertInstanceOf(Standard::class, $standard);
        $this->assertEquals($id, $standard->getId());
        $this->assertEquals($name, $standard->getName());
        $this->assertEquals($deptId, $standard->getDepartmentId());
    }

    /**
     * Run: composer test -- --filter StandardTest::testCreateThrowsExceptionWhenIdIsEmpty
     * 
     * @return void
     */
    public function testCreateThrowsExceptionWhenIdIsEmpty(): void
    {
        $this->expectException(StandardEmptyIdException::class);
        Standard::create('', 'Name', 'Dept-1');
    }

    /**
     * Run: composer test -- --filter StandardTest::testCreateThrowsExceptionWhenIdIsInvalid
     * 
     * @return void
     */
    #[DataProvider('invalidIdProvider')]
    public function testCreateThrowsExceptionWhenIdIsInvalid(string $invalidId): void
    {
        $this->expectException(StandardInvalidIdException::class);
        Standard::create($invalidId, 'Name', 'Dept-1');
    }

    public static function invalidIdProvider(): array
    {
        return [
            'id_la_chu' => ['abc'],
            'id_la_so_khong' => ['0'],
            'id_la_so_am' => ['-5'],
            'id_chua_ky_tu_dac_biet' => ['1.1'],
        ];
    }

    /**
     * Run: composer test -- --filter StandardTest::testCreateThrowsExceptionWhenNameIsEmpty
     * 
     * @return void
     */
    public function testCreateThrowsExceptionWhenNameIsEmpty(): void
    {
        $this->expectException(StandardEmptyNameException::class);
        Standard::create('1', '', 'Dept-1');
    }

    /**
     * Run: composer test -- --filter StandardTest::testCreateThrowsExceptionWhenDepartmentIdIsEmpty
     * 
     * @return void
     */
    public function testCreateThrowsExceptionWhenDepartmentIdIsEmpty(): void
    {
        $this->expectException(StandardEmptyDepartmentIdException::class);
        Standard::create('1', 'Name', '');
    }
}