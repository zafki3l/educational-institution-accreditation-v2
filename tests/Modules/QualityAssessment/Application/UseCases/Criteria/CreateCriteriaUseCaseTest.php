<?php

namespace Tests\Unit\Modules\QualityAssessment\Application\UseCases\Criteria;

use App\Modules\QualityAssessment\Application\Requests\Criteria\CreateCriteriaRequestInterface;
use App\Modules\QualityAssessment\Application\UseCases\Criteria\CreateCriteriaUseCase;
use App\Modules\QualityAssessment\Domain\Entities\Criteria;
use App\Modules\QualityAssessment\Domain\Exception\Criteria\CriteriaIdExistsException;
use App\Modules\QualityAssessment\Domain\Repositories\CriteriaRepositoryInterface;
use App\Modules\QualityAssessment\Domain\Services\CriteriaIdExistsCheckerInterface;
use App\Shared\Logging\LoggerInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TraitHelper\DebugHelper;

final class CreateCriteriaUseCaseTest extends TestCase
{
    use DebugHelper;

    private CriteriaRepositoryInterface&MockObject $repository;
    private LoggerInterface&MockObject $logger;
    private CriteriaIdExistsCheckerInterface&MockObject $idChecker;
    private CreateCriteriaUseCase $useCase;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(CriteriaRepositoryInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->idChecker = $this->createMock(CriteriaIdExistsCheckerInterface::class);
        
        $this->useCase = new CreateCriteriaUseCase(
            $this->repository, 
            $this->logger, 
            $this->idChecker
        );
    }

    /**
     * Run: composer test -- --filter CreateCriteriaUseCaseTest::testExecuteSuccessfully
     * 
     * @return void
     */
    public function testExecuteSuccessfully(): void
    {
        $actorId = 'user-1';
        $request = $this->createMock(CreateCriteriaRequestInterface::class);
        $request->method('getId')->willReturn('1.1');
        $request->method('getStandardId')->willReturn('1');
        $request->method('getName')->willReturn('Tiêu chí chất lượng');

        $this->idChecker->method('check')->with('1.1')->willReturn(false);

        $this->debug('CHECK ID STATUS', ['id' => '1.1', 'exists' => false]);

        $this->repository->expects($this->once())
            ->method('create')
            ->with($this->isInstanceOf(Criteria::class));

        $this->logger->expects($this->once())->method('write');

        $this->useCase->execute($request, $actorId);
    }

    /**
     * Run: composer test -- --filter CreateCriteriaUseCaseTest::testExecuteThrowsExceptionWhenIdAlreadyExists
     * 
     * @return void
     */
    public function testExecuteThrowsExceptionWhenIdAlreadyExists(): void
    {
        $id = '1.1';
        $request = $this->createMock(CreateCriteriaRequestInterface::class);
        $request->method('getId')->willReturn($id);

        $this->idChecker->method('check')->with($id)->willReturn(true);

        $this->expectException(CriteriaIdExistsException::class);

        $this->repository->expects($this->never())->method('create');
        $this->logger->expects($this->never())->method('write');

        $this->useCase->execute($request, 'user-1');
    }
}