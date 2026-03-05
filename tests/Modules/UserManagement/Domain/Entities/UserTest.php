<?php

namespace Tests\Unit\Modules\UserManagement\Domain\Entities;

use App\Modules\UserManagement\Domain\Entities\User;
use App\Modules\UserManagement\Domain\ValueObjects\UserId;
use App\Modules\Authentication\Domain\ValueObjects\AuthId;
use App\Modules\UserManagement\Domain\ValueObjects\Email;
use App\Modules\UserManagement\Domain\ValueObjects\Password;
use App\Modules\UserManagement\Domain\Exception\UserNameEmptyException;
use App\Modules\UserManagement\Domain\Exception\RoleMissingException;
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    private function createValidUser(): User
    {
        return User::create(
            UserId::fromString('f47ac10b-58cc-4372-a567-0e02b2c3d479'),
            AuthId::fromString('auth-123'),
            'Nguyen',
            'An',
            Email::fromString('an@example.com'),
            Password::fromPlain('SafePass123'),
            1, // role_id
            'dept-001'
        );
    }

    /**
     * Run: composer test -- --filter UserTest::testCreateWithValidData
     * 
     * @return void
     */
    public function testCreateWithValidData(): void
    {
        $user = $this->createValidUser();

        $this->assertEquals('Nguyen An', $user->getFullName());
        $this->assertEquals(1, $user->getRoleId());
        $this->assertInstanceOf(Email::class, $user->getEmail());
    }

    /**
     * Run: composer test -- --filter UserTest::testThrowsExceptionWhenFirstNameIsEmpty
     * 
     * @return void
     */
    public function testThrowsExceptionWhenFirstNameIsEmpty(): void
    {
        $this->expectException(UserNameEmptyException::class);

        User::create(
            UserId::fromString('f47ac10b-58cc-4372-a567-0e02b2c3d479'),
            AuthId::fromString('auth-123'),
            '', // First name empty
            'An',
            null,
            Password::fromPlain('SafePass123'),
            1,
            null
        );
    }

    /**
     * Run: composer test -- --filter UserTest::testUpdateUserInfo
     * 
     * @return void
     */
    public function testUpdateUserInfo(): void
    {
        $user = $this->createValidUser();

        $user->update(
            'Tran',
            'Binh',
            'binh.new@example.com',
            2,
            'dept-999'
        );

        $this->assertEquals('Tran Binh', $user->getFullName());
        $this->assertEquals('binh.new@example.com', $user->getEmail()->value());
        $this->assertEquals(2, $user->getRoleId());
        $this->assertEquals('dept-999', $user->getDepartmentId());
    }

    /**
     * Run: composer test -- --filter UserTest::testUpdateUserInfo
     * 
     * @return void
     */
    public function testUpdatesCorrectlyWhenOptionalFieldsAreNull(): void
    {
        $user = $this->createValidUser();
        $oldEmail = $user->getEmail();

        $user->update('Nguyen', 'An', null, 1, null);

        $this->assertSame($oldEmail, $user->getEmail());
    }

    /**
     * Run: composer test -- --filter UserTest::testThrowsExceptionIfRoleIdIsZero
     * 
     * @return void
     */
    public function testThrowsExceptionIfRoleIdIsZero(): void
    {
        $user = $this->createValidUser();
        
        $this->expectException(RoleMissingException::class);
        
        $user->changeRole(0);
    }
}