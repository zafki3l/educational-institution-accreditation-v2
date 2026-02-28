<?php

namespace App\Modules\QualityAssessment\Infrastructure\ServiceProvider;

use App\Modules\QualityAssessment\Application\Requests\Evidence\CreateEvidenceRequestInterface;
use App\Modules\QualityAssessment\Application\Requests\Evidence\UpdateEvidenceRequestInterface;
use App\Modules\QualityAssessment\Domain\Repositories\EvidenceRepositoryInterface;
use App\Modules\QualityAssessment\Domain\Services\EvidenceFileUploaderInterface;
use App\Modules\QualityAssessment\Infrastructure\Repositories\EvidenceRepository;
use App\Modules\QualityAssessment\Infrastructure\Services\EvidenceFileUploader;
use App\Modules\QualityAssessment\Presentation\Requests\Evidence\CreateEvidenceRequest;
use App\Modules\QualityAssessment\Presentation\Requests\Evidence\UpdateEvidenceRequest;
use Core\ServiceProvider;
use Illuminate\Container\Container;

final class EvidenceServiceProvider extends ServiceProvider
{
    public function register(Container $container): void
    {
        $container->bind(
            CreateEvidenceRequestInterface::class,
            CreateEvidenceRequest::class
        );

        $container->bind(
            EvidenceRepositoryInterface::class,
            EvidenceRepository::class
        );

        $container->bind(
            EvidenceFileUploaderInterface::class,
            EvidenceFileUploader::class
        );

        $container->bind(
            UpdateEvidenceRequestInterface::class,
            UpdateEvidenceRequest::class
        );
    }
}