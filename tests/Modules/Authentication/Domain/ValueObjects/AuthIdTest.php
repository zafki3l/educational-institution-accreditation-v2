<?php

namespace Tests\Modules\Authentication\Domain\ValueObjects;

use App\Modules\Authentication\Domain\ValueObjects\AuthId;
use PHPUnit\Framework\TestCase;

final class AuthIdTest extends TestCase
{
    /**
     * Run: composer test -- --filter AuthIdTest::testFromStringShouldKeepValue
     * @return void
     */
    public function testFromStringShouldKeepValue(): void
    {
        $idString = 'random-string-123';
        $authId = AuthId::fromString($idString);

        $this->assertSame($idString, $authId->value());
    }

    /**
     * Run: composer test -- --filter AuthIdTest::testEqualsShouldReturnTrueWhenValuesAreSame
     * @return void
     */
    public function testEqualsShouldReturnTrueWhenValuesAreSame(): void
    {
        $id = 'test-id';
        $authId1 = AuthId::fromString($id);
        $authId2 = AuthId::fromString($id);

        $this->assertTrue($authId1->equals($authId2));
    }

    /**
     * Run: composer test -- --filter AuthIdTest::testEqualsShouldReturnFalseWhenValuesAreDifferent
     * @return void
     */
    public function testEqualsShouldReturnFalseWhenValuesAreDifferent(): void
    {
        $authId1 = AuthId::fromString('id-1');
        $authId2 = AuthId::fromString('id-2');

        $this->assertFalse($authId1->equals($authId2));
    }

    /**
     * Run: composer test -- --filter AuthIdTest::testGenerateShouldProduceUniqueHexValues
     * @return void
     */
    public function testGenerateShouldProduceUniqueHexValues(): void
    {
        $authId1 = AuthId::generate();
        $authId2 = AuthId::generate();

        $this->assertNotSame($authId1->value(), $authId2->value());
        $this->assertSame(32, strlen($authId1->value()));
    }
}