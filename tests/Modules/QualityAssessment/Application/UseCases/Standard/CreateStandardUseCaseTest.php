<?php

namespace Tests\Unit\Modules\QualityAssessment\Application\UseCases\Standard;

use App\Modules\QualityAssessment\Application\Requests\Standard\CreateStandardRequestInterface;
use App\Modules\QualityAssessment\Application\UseCases\Standard\CreateStandardUseCase;
use App\Modules\QualityAssessment\Domain\Entities\Standard;
use App\Modules\QualityAssessment\Domain\Repositories\StandardRepositoryInterface;
use App\Shared\Domain\Exception\DomainException;
use App\Shared\Logging\LoggerInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\TraitHelper\DebugHelper;

final class CreateStandardUseCaseTest extends TestCase
{
    use DebugHelper;

    private StandardRepositoryInterface&MockObject $repository;
    private LoggerInterface&MockObject $logger;
    private CreateStandardUseCase $useCase;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(StandardRepositoryInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->useCase = new CreateStandardUseCase($this->repository, $this->logger);
    }

    /**
     * Run: composer test -- --filter CreateStandardUseCaseTest::testExecuteSuccessfully
     * 
     * @return void
     */
    public function testExecuteSuccessfully(): void
    {
        $actorId = 'user-admin';
        
        $request = $this->createMock(CreateStandardRequestInterface::class);
        $request->method('getId')->willReturn('1');
        $request->method('getName')->willReturn('Tiêu chuẩn 1');
        $request->method('getDepartmentId')->willReturn('DEPT-01');

        $this->debug('INPUT DATA', [
            'id' => $request->getId(),
            'name' => $request->getName()
        ]);

        $this->repository->expects($this->once())
            ->method('create')
            ->with($this->isInstanceOf(Standard::class));

        $this->logger->expects($this->once())
            ->method('write');

        $this->useCase->execute($request, $actorId);
    }

    /**
     * Run: composer test -- --filter CreateStandardUseCaseTest::testExecuteThrowsExceptionForMissingFields
     * 
     * @return void
     */
    #[DataProvider('invalidRequestProvider')]
    public function testExecuteThrowsExceptionForMissingFields(
        string $id, 
        string $name, 
        string $deptId, 
        string $expectedMessage
    ): void {
        $request = $this->createMock(CreateStandardRequestInterface::class);
        $request->method('getId')->willReturn($id);
        $request->method('getName')->willReturn($name);
        $request->method('getDepartmentId')->willReturn($deptId);

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage($expectedMessage);

        $this->repository->expects($this->never())->method('create');
        $this->logger->expects($this->never())->method('write');

        $this->useCase->execute($request, 'actor-123');
    }

    public static function invalidRequestProvider(): array
    {
        return [
            'trong_id' => ['', 'Name', 'Dept', 'Mã tiêu chuẩn không được để trống'],
            'trong_name' => ['1', '', 'Dept', 'Tên tiêu chuẩn không được để trống'],
            'trong_dept' => ['1', 'Name', '', 'Vui lòng chọn phòng ban'],
        ];
    }
}