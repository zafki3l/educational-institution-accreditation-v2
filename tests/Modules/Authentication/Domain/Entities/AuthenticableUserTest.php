<?php

namespace Tests\Modules\Authentication\Domain\Entities;

use App\Modules\Authentication\Domain\Entities\AuthenticableUser;
use App\Modules\Authentication\Domain\ValueObjects\AuthId;
use App\Modules\UserManagement\Domain\ValueObjects\Email;
use App\Modules\UserManagement\Domain\ValueObjects\Password;
use App\Modules\UserManagement\Domain\ValueObjects\UserId;
use App\Shared\Infrastructure\UuidGenerator;
use PHPUnit\Framework\TestCase;
use Tests\TraitHelper\DebugHelper;

final class AuthenticableUserTest extends TestCase
{
    use DebugHelper;

    private AuthenticableUser $authenticableUser;
    private UserId $expectedUserId;
    private string $expectedIdentifier;
    private Password $expectedPassword;
    private int $expectedRoleId;

    protected function setUp(): void
    {
        $withAuthId = AuthId::generate()->value();
        $withEmail = Email::fromString('phamdinhthai123@gmail.com')->value();

        $this->expectedUserId = UserId::fromString(UuidGenerator::v4());
        $this->expectedIdentifier = $withEmail;
        $this->expectedPassword = Password::fromPlain('password123');
        $this->expectedRoleId = 2;

        $this->authenticableUser = AuthenticableUser::create(
            $this->expectedUserId, 
            $this->expectedIdentifier, 
            $this->expectedPassword, 
            $this->expectedRoleId
        );
    }

    /**
     * Run: composer test -- --filter AuthenticableUserTest::testVerifyTrue
     * 
     * @return void
     */
    public function testVerifyTrue(): void
    {
        $inputPass = 'password123';
        $isVerify = $this->authenticableUser->verify($inputPass);

        $this->debug('AuthenticableUser testVerifyTrue', [
            'input_password' => $inputPass,
            'user_hashed_password' => $this->authenticableUser->getPassword()->value(),
            'result' => $isVerify ? 'Match' : 'Not Match'
        ]);

        $this->assertTrue($isVerify);
    }

    /**
     * Run: composer test -- --filter AuthenticableUserTest::testVerifyFalse
     * 
     * @return void
     */
    public function testVerifyFalse(): void
    {
        $wrongPass = 'password1234';
        $isVerify = $this->authenticableUser->verify($wrongPass);

        $this->debug('AuthenticableUser testVerifyFalse', [
            'input_password' => $wrongPass,
            'result' => $isVerify ? 'Match' : 'Not Match'
        ]);

        $this->assertFalse($isVerify);
    }

    /**
     * Run: composer test -- --filter AuthenticableUserTest::testGetters
     */
    public function testGetters(): void
    {
        $this->debug('AuthenticableUser testGetters', [
            'user_id'    => $this->authenticableUser->getUserId()->value(),
            'identifier' => $this->authenticableUser->getIdentifier(),
            'password'   => $this->authenticableUser->getPassword()->value(),
            'role_id'    => $this->authenticableUser->getRoleId(),
        ]);

        $this->assertTrue($this->authenticableUser->getUserId()->equals($this->expectedUserId));
        $this->assertSame($this->expectedIdentifier, $this->authenticableUser->getIdentifier());
        $this->assertSame($this->expectedPassword->value(), $this->authenticableUser->getPassword()->value());
        $this->assertSame($this->expectedRoleId, $this->authenticableUser->getRoleId());
    }
}