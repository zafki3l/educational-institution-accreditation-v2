<?php

namespace Tests\Unit\Modules\UserManagement\Domain\ValueObjects;

use App\Modules\UserManagement\Domain\ValueObjects\Email;
use App\Modules\UserManagement\Domain\Exception\InvalidEmailFormatException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class EmailTest extends TestCase
{
    /**
     * Run: composer test -- --filter EmailTest::testCanBeCreatedFromAValidEmailString
     * 
     * @return void
     */
    public function testCanBeCreatedFromAValidEmailString(): void
    {
        $emailString = '  USER@Example.com  ';
        $email = Email::fromString($emailString);

        $this->assertInstanceOf(Email::class, $email);
        $this->assertEquals('user@example.com', $email->value());
    }

    /**
     * Run: composer test -- --filter EmailTest::testThrowsExceptionForInvalidEmailFormat
     * 
     * @return void
     */
    public function testThrowsExceptionForInvalidEmailFormat(): void
    {
        $this->expectException(InvalidEmailFormatException::class);

        Email::fromString('invalid-email-format');
    }

    /**
     * Run: composer test -- --filter EmailTest::TestCanBeComparedForEquality
     * 
     * @return void
     */
    public function testCanBeComparedForEquality(): void
    {
        $email1 = Email::fromString('test@example.com');
        $email2 = Email::fromString('test@example.com');
        $email3 = Email::fromString('other@example.com');

        $this->assertTrue($email1->equals($email2));
        $this->assertFalse($email1->equals($email3));
    }

    /**
     * Run: composer test -- --filter EmailTest::testFailsValidationForVariousInvalidFormats
     * 
     * @return void
     */
    #[Test]
    #[DataProvider('invalidEmailProvider')]
    public function testFailsValidationForVariousInvalidFormats(string $invalidEmail): void
    {
        $this->expectException(InvalidEmailFormatException::class);
        Email::fromString($invalidEmail);
    }

    public static function invalidEmailProvider(): array
    {
        return [
            ['plainaddress'],
            ['#@%^%#$@#$@#.com'],
            ['@example.com'],
            ['Joe Smith <email@example.com>'],
            ['email.example.com'],
            [''],
        ];
    }
}