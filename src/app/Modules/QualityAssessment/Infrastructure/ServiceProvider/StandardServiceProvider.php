<?php

namespace App\Modules\QualityAssessment\Infrastructure\ServiceProvider;

use App\Modules\QualityAssessment\Application\Readers\StandardReaderInterface;
use App\Modules\QualityAssessment\Application\Requests\Standard\CreateStandardRequestInterface;
use App\Modules\QualityAssessment\Domain\Repositories\StandardRepositoryInterface;
use App\Modules\QualityAssessment\Infrastructure\Readers\StandardReader;
use App\Modules\QualityAssessment\Infrastructure\Repositories\StandardRepository;
use App\Modules\QualityAssessment\Presentation\Requests\Standard\CreateStandardRequest;
use Core\ServiceProvider;
use Illuminate\Container\Container;

final class StandardServiceProvider extends ServiceProvider
{
    public function register(Container $container): void
    {
        $container->bind(
            CreateStandardRequestInterface::class,
            CreateStandardRequest::class
        );

        $container->bind(
            StandardRepositoryInterface::class,
            StandardRepository::class
        );

        $container->bind(
            StandardReaderInterface::class, 
            StandardReader::class
        );
    }
}