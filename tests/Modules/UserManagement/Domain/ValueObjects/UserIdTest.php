<?php

namespace Tests\Unit\Modules\UserManagement\Domain\ValueObjects;

use App\Modules\UserManagement\Domain\ValueObjects\UserId;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use InvalidArgumentException;

final class UserIdTest extends TestCase
{
    /**
     * Run: composer test -- --filter UserIdTest::testCreateFromValidUuidV4
     * 
     * @return void
     */
    public function testCreateFromValidUuidV4(): void
    {
        $validUuid = 'f47ac10b-58cc-4372-a567-0e02b2c3d479';
        $userId = UserId::fromString($validUuid);

        $this->assertInstanceOf(UserId::class, $userId);
        $this->assertEquals($validUuid, $userId->value());
    }

    /**
     * Run: composer test -- --filter UserIdTest::testNormalizesUuidToLowercase
     * 
     * @return void
     */
    public function testNormalizesUuidToLowercase(): void
    {
        $upperUuid = 'F47AC10B-58CC-4372-A567-0E02B2C3D479';
        $userId = UserId::fromString($upperUuid);

        $this->assertEquals(strtolower($upperUuid), $userId->value());
    }

    /**
     * Run: composer test -- --filter UserIdTest::testThrowsExceptionForInvalidUuid
     * 
     * @return void
     */
    #[DataProvider('invalidUuidProvider')]
    public function testThrowsExceptionForInvalidUuid(string $invalidUuid): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid UUID");

        UserId::fromString($invalidUuid);
    }

    /**
     * Run: composer test -- --filter UserIdTest::testCheckEquality
     * 
     * @return void
     */
    public function testCheckEquality(): void
    {
        $id1 = UserId::fromString('f47ac10b-58cc-4372-a567-0e02b2c3d479');
        $id2 = UserId::fromString('f47ac10b-58cc-4372-a567-0e02b2c3d479');
        $id3 = UserId::fromString('00000000-0000-4000-8000-000000000000');

        $this->assertTrue($id1->equals($id2));
        $this->assertFalse($id1->equals($id3));
    }

    public static function invalidUuidProvider(): array
    {
        return [
            ['not-a-uuid'],
            ['12345'],
            ['g47ac10b-58cc-4372-a567-0e02b2c3d479'],
            ['f47ac10b-58cc-3372-a567-0e02b2c3d479'],
            [''],
        ];
    }
}