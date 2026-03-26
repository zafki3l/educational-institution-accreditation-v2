<?php

namespace App\Modules\UserProfile\Application\Listeners;

use App\Modules\UserProfile\Domain\Events\UserProfileUpdated;
use App\Shared\Logging\LoggerInterface;

final class UserProfileUpdatedLoggerListener
{
    public function __construct(private LoggerInterface $logger) {}

    public function handle(UserProfileUpdated $event): void 
    {
        try {
            $this->logger->write(
                'info',
                'update', 
                "Người dùng {$event->actor_id} đã cập nhật hồ sơ cá nhân của mình",
                $event->actor_id,
                [
                    'id' => $event->actor_id,
                    'old_first_name' => $event->old_first_name,
                    'new_first_name' => $event->new_first_name,
                    'old_last_name' => $event->old_last_name,
                    'new_last_name' => $event->new_last_name,
                    'old_email' => $event->old_email,
                    'new_email' => $event->new_email
                ]
            );
        } catch (\Throwable $e) {
        }
    }
}