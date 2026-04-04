<?php

use App\Modules\Authentication\Infrastructure\ListenerProvider\AuthenticationListenerProvider;
use App\Modules\Authorization\Infrastructure\ListenerProvider\RoleListenerProvider;
use App\Modules\DepartmentManagement\Infrastructure\ListenerProvider\DepartmentListenerProvider;
use App\Modules\QualityAssessment\Infrastructure\ListenerProvider\CriteriaListenerProvider;
use App\Modules\QualityAssessment\Infrastructure\ListenerProvider\MilestoneListenerProvider;
use App\Modules\QualityAssessment\Infrastructure\ListenerProvider\StandardListenerProvider;
use App\Modules\UserManagement\Infrastructure\ListenerProvider\UserListenerProvider;
use App\Modules\UserProfile\Infrastructure\ListenerProvider\UserProfileListenerProvider;

return array_merge(
    UserListenerProvider::register(),
    AuthenticationListenerProvider::register(),
    RoleListenerProvider::register(),
    DepartmentListenerProvider::register(),
    UserProfileListenerProvider::register(),
    StandardListenerProvider::register(),
    CriteriaListenerProvider::register(),
    MilestoneListenerProvider::register()
);
