<?php

namespace Tests\Unit\Modules\UserManagement\Domain\ValueObjects;

use App\Modules\UserManagement\Domain\ValueObjects\Password;
use App\Modules\UserManagement\Domain\Exception\PasswordEmptyException;
use App\Modules\UserManagement\Domain\Exception\PasswordTooShortException;
use App\Modules\UserManagement\Domain\Exception\PasswordInvalidFormatException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

final class PasswordTest extends TestCase
{
    /**
     * Run: composer test -- --filter PasswordTest::testCreatePasswordFromValidPlainText
     * 
     * @return void
     */
    public function testCreatePasswordFromValidPlainText(): void
    {
        $plain = 'SafePass123';
        $password = Password::fromPlain($plain);

        $this->assertInstanceOf(Password::class, $password);

        $this->assertNotEquals($plain, $password->value());
        $this->assertTrue($password->verify($plain));
    }

    /**
     * Run: composer test -- --filter PasswordTest::testCreateFromExistingHash
     * 
     * @return void
     */
    public function testCreateFromExistingHash(): void
    {
        $hash = password_hash('existingHash123', PASSWORD_DEFAULT);
        $password = Password::fromHash($hash);

        $this->assertEquals($hash, $password->value());
        $this->assertTrue($password->verify('existingHash123'));
    }

    /**
     * Run: composer test -- --filter PasswordTest::testCreateFromExistingHash
     * 
     * @return void
     */
    public function testThrowsExceptionIfPasswordIsEmpty(): void
    {
        $this->expectException(PasswordEmptyException::class);
        Password::fromPlain('   ');
    }

    /**
     * Run: composer test -- --filter PasswordTest::testThrowsExceptionIfPasswordIsTooShort
     * 
     * @return void
     */
    public function testThrowsExceptionIfPasswordIsTooShort(): void
    {
        $this->expectException(PasswordTooShortException::class);
        Password::fromPlain('Short1'); // Chỉ có 6 ký tự
    }

    /**
     * Run: composer test -- --filter PasswordTest::testThrowsExceptionForInvalidFormat
     * 
     * @return void
     */
    #[DataProvider('invalidFormatProvider')]
    public function testThrowsExceptionForInvalidFormat(string $invalidPlain): void
    {
        $this->expectException(PasswordInvalidFormatException::class);
        Password::fromPlain($invalidPlain);
    }

    public static function invalidFormatProvider(): array
    {
        return [
            ['123456789'], // only number
            ['abcdefghijk'], // only text
        ];
    }
}