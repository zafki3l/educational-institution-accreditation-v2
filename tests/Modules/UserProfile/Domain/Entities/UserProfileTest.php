<?php

namespace Tests\Unit\Modules\UserProfile\Domain\Entities;

use App\Modules\UserProfile\Domain\Entities\UserProfile;
use App\Modules\UserProfile\Domain\Exceptions\InvalidEmailFormatException;
use App\Modules\UserProfile\Domain\Exceptions\UserIdEmptyException;
use App\Modules\UserProfile\Domain\Exceptions\UserNameEmptyException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class UserProfileTest extends TestCase
{
    /**
     * Run: composer test -- --filter UserProfileTest::it_can_be_created_successfully
     */
    #[Test]
    public function it_can_be_created_successfully(): void
    {
        $id = 'user-123';
        $firstName = 'Nguyen';
        $lastName = 'An';

        $profile = UserProfile::create($id, $firstName, $lastName);

        $this->assertEquals($id, $profile->getId());
        $this->assertEquals($firstName, $profile->getFirstName());
        $this->assertEquals($lastName, $profile->getLastName());
        $this->assertNull($profile->getEmail());
    }

    /**
     * Run: composer test -- --filter UserProfileTest::it_throws_exception_if_id_is_empty
     */
    #[Test]
    public function it_throws_exception_if_id_is_empty(): void
    {
        $this->expectException(UserIdEmptyException::class);
        UserProfile::create('', 'Nguyen', 'An');
    }

    /**
     * Run: composer test -- --filter UserProfileTest::it_throws_exception_if_both_names_are_empty
     */
    #[Test]
    public function it_throws_exception_if_both_names_are_empty(): void
    {
        $this->expectException(UserNameEmptyException::class);
        UserProfile::create('id-1', '', '');
    }

    /**
     * Run: composer test -- --filter UserProfileTest::it_can_be_reconstituted_from_persistence
     */    
    #[Test]
    public function it_can_be_reconstituted_from_persistence(): void
    {
        // Giả lập dữ liệu từ DB (có thể chứa email)
        $profile = UserProfile::fromPersistent('id-1', 'Nguyen', 'An', 'an@gmail.com');

        $this->assertEquals('an@gmail.com', $profile->getEmail());
    }

    /**
     * Run: composer test -- --filter UserProfileTest::it_can_update_email_with_valid_format
     */ 
    #[Test]
    public function it_can_update_email_with_valid_format(): void
    {
        $profile = UserProfile::create('id-1', 'Nguyen', 'An');
        $newEmail = 'new-email@example.com';

        $profile->updateEmail($newEmail);

        $this->assertEquals($newEmail, $profile->getEmail());
    }

    /**
     * Run: composer test -- --filter UserProfileTest::it_throws_exception_for_invalid_email_format
     */ 
    #[Test]
    public function it_throws_exception_for_invalid_email_format(): void
    {
        $profile = UserProfile::create('id-1', 'Nguyen', 'An');

        $this->expectException(InvalidEmailFormatException::class);
        $profile->updateEmail('invalid-email');
    }
}