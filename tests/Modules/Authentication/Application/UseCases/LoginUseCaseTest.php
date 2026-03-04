<?php

namespace Tests\Modules\Authentication\Application\UseCases;

use App\Modules\Authentication\Application\Requests\LoginRequestInterface;
use App\Modules\Authentication\Application\UseCases\LoginUseCase;
use App\Modules\Authentication\Domain\Entities\AuthenticableUser;
use App\Modules\Authentication\Domain\Repositories\AuthenticableUserRepositoryInterface;
use App\Modules\Authentication\Domain\ValueObjects\AuthId;
use App\Modules\UserManagement\Domain\ValueObjects\Email;
use App\Modules\UserManagement\Domain\ValueObjects\Password;
use App\Modules\UserManagement\Domain\ValueObjects\UserId;
use App\Shared\Infrastructure\UuidGenerator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\TraitHelper\DebugHelper;

final class LoginUseCaseTest extends TestCase
{
    use DebugHelper;

    private AuthenticableUser $authenticableUser;
    private AuthenticableUserRepositoryInterface&MockObject $repositoryMock;
    private LoginUseCase $loginUseCase;
    private string $expectedIdentifier;
    private string $plainPassword;

    protected function setUp(): void
    {
        parent::setUp();

        $withAuthId = AuthId::generate()->value();
        $withEmail = Email::fromString('phamdinhthai123@gmail.com')->value();
        
        $this->expectedIdentifier = strtolower($withEmail); 
        $this->plainPassword = 'phamdinhthai123';
        
        $userId = UserId::fromString(UuidGenerator::v4());
        $password = Password::fromPlain($this->plainPassword); 
        $role_id = 2;

        $this->authenticableUser = AuthenticableUser::create(
            $userId,
            $this->expectedIdentifier,
            $password,
            $role_id
        );

        $this->repositoryMock = $this->createMock(AuthenticableUserRepositoryInterface::class);
        
        $this->loginUseCase = new LoginUseCase($this->repositoryMock);
    }

    private function createMockRequest(string $identifier, string $password): LoginRequestInterface&MockObject
    {
        $request = $this->createMock(LoginRequestInterface::class);
        $request->method('getIdentifier')->willReturn($identifier);
        $request->method('getPassword')->willReturn($password);
        
        return $request;
    }

    /**
     * Run: composer test -- --filter LoginUseCaseTest::testExecuteReturnUserWhenEmailAndPasswordCorrect
     * 
     * @return void
     */
    public function testExecuteReturnUserWhenEmailAndPasswordCorrect(): void
    {
        $request = $this->createMockRequest($this->expectedIdentifier, $this->plainPassword);

        $this->debug('testExecuteReturnUserWhenEmailAndPasswordCorrect INPUT', [
            'identifier' => $request->getIdentifier(),
            'password' => $request->getPassword()
        ]);

        $this->repositoryMock->expects($this->once())
            ->method('findByIdentifier')
            ->with($request->getIdentifier())
            ->willReturn($this->authenticableUser);

        $result = $this->loginUseCase->execute($request);

        $this->debug('testExecuteReturnUserWhenEmailAndPasswordCorrect OUTPUT', [
            'user_id' => $result->getUserId()->value(),
            'identifier' => $result->getIdentifier(),
            'password' => $result->getPassword()->value(),
            'role_id' => $result->getRoleId(),
        ]);

        $this->assertNotNull($result);
        $this->assertSame($this->authenticableUser, $result);
    }

    /**
     * Run: composer test -- --filter LoginUseCaseTest::testExecuteReturnNullWhenEmailNotExists
     * 
     * @return void
     */
    public function testExecuteReturnNullWhenEmailNotExists(): void
    {
        $request = $this->createMockRequest('abc123@email.com', $this->plainPassword);

        $this->debug('testExecuteReturnNullWhenEmailNotExists INPUT', [
            'identifier' => $request->getIdentifier(),
            'password' => $request->getPassword()
        ]);

        $this->repositoryMock
                ->expects($this->once())
                ->method('findByIdentifier')
                ->with($request->getIdentifier())
                ->willReturn(null);

        $result = $this->loginUseCase->execute($request);

        $this->debug('testExecuteReturnNullWhenEmailNotExists OUTPUT', $result);

        $this->assertNull($result);
    }

    /**
     * Run: composer test -- --filter LoginUseCaseTest::testExecuteReturnNullWhenPasswordIncorrect
     * @return void
     */
    public function testExecuteReturnNullWhenPasswordIncorrect(): void
    {
        $request = $this->createMockRequest($this->expectedIdentifier, 'phamdt12341312incorrectpass');

        $this->debug('testExecuteReturnNullWhenPasswordIncorrect INPUT', [
            'identifier' => $request->getIdentifier(),
            'password' => $request->getPassword()
        ]);

        $this->repositoryMock
                ->expects($this->once())
                ->method('findByIdentifier')
                ->with($request->getIdentifier())
                ->willReturn($this->authenticableUser);

        $result = $this->loginUseCase->execute($request);

        $this->debug('testExecuteReturnNullWhenPasswordIncorrect OUTPUT', $result);

        $this->assertNull($result);
    }
}