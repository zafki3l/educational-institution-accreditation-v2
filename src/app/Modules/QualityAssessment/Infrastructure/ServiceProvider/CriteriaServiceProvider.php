<?php

namespace App\Modules\QualityAssessment\Infrastructure\ServiceProvider;

use App\Modules\QualityAssessment\Application\Readers\CriteriaReaderInterface;
use App\Modules\QualityAssessment\Application\Requests\Criteria\CreateCriteriaRequestInterface;
use App\Modules\QualityAssessment\Application\Requests\Criteria\UpdateCriteriaRequestInterface;
use App\Modules\QualityAssessment\Domain\Repositories\CriteriaRepositoryInterface;
use App\Modules\QualityAssessment\Domain\Services\CriteriaIdExistsCheckerInterface;
use App\Modules\QualityAssessment\Infrastructure\Readers\CriteriaReader;
use App\Modules\QualityAssessment\Infrastructure\Repositories\CriteriaRepository;
use App\Modules\QualityAssessment\Infrastructure\Services\CriteriaIdExistsChecker;
use App\Modules\QualityAssessment\Presentation\Requests\Criteria\CreateCriteriaRequest;
use App\Modules\QualityAssessment\Presentation\Requests\Criteria\UpdateCriteriaRequest;
use Core\ServiceProvider;
use Illuminate\Container\Container;

class CriteriaServiceProvider extends ServiceProvider
{
    public function register(Container $container): void
    {
        $container->bind(
            CreateCriteriaRequestInterface::class,
            CreateCriteriaRequest::class
        );

        $container->bind(
            CriteriaRepositoryInterface::class,
            CriteriaRepository::class
        );

        $container->bind(
            CriteriaIdExistsCheckerInterface::class,
            CriteriaIdExistsChecker::class
        );

        $container->bind(
            UpdateCriteriaRequestInterface::class,
            UpdateCriteriaRequest::class
        );

        $container->bind(
            CriteriaReaderInterface::class,
            CriteriaReader::class
        );
    }
}