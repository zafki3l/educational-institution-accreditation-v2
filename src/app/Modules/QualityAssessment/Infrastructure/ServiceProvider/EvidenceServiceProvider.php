<?php

namespace App\Modules\QualityAssessment\Infrastructure\ServiceProvider;

use App\Modules\QualityAssessment\Application\Readers\EvidenceReaderInterface;
use App\Modules\QualityAssessment\Application\Requests\Evidence\CreateEvidenceRequestInterface;
use App\Modules\QualityAssessment\Application\Requests\Evidence\UpdateEvidenceRequestInterface;
use App\Modules\QualityAssessment\Domain\Repositories\EvidenceRepositoryInterface;
use App\Modules\QualityAssessment\Domain\Services\EvidenceFileUploaderInterface;
use App\Modules\QualityAssessment\Domain\Services\EvidenceIdExistsCheckerInterface;
use App\Modules\QualityAssessment\Domain\Services\EvidenceIssuedDateEmptyCheckerInterface;
use App\Modules\QualityAssessment\Domain\Services\EvidencePermissionCheckerInterface;
use App\Modules\QualityAssessment\Infrastructure\Readers\EvidenceReader;
use App\Modules\QualityAssessment\Infrastructure\Repositories\EvidenceRepository;
use App\Modules\QualityAssessment\Infrastructure\Services\EvidenceFileUploader;
use App\Modules\QualityAssessment\Infrastructure\Services\EvidenceIdExistsChecker;
use App\Modules\QualityAssessment\Infrastructure\Services\EvidenceIssuedDateEmptyChecker;
use App\Modules\QualityAssessment\Infrastructure\Services\EvidencePermissionChecker;
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

        $container->bind(
            EvidenceIdExistsCheckerInterface::class,
            EvidenceIdExistsChecker::class
        );

        $container->bind(
            EvidenceIssuedDateEmptyCheckerInterface::class,
            EvidenceIssuedDateEmptyChecker::class
        );

        $container->bind(
            EvidencePermissionCheckerInterface::class,
            EvidencePermissionChecker::class
        );

        $container->bind(
            EvidenceReaderInterface::class,
            EvidenceReader::class
        );
    }
}