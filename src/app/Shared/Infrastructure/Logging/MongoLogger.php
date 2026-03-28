<?php

namespace App\Shared\Infrastructure\Logging;

use App\Shared\Contracts\Logging\LoggerInterface;
use App\Shared\Infrastructure\Persistence\MongoDBConnection;
use MongoDB\Collection;

class MongoLogger implements LoggerInterface
{
    private ?Collection $collection = null;
    private MongoDBConnection $mongo;

    public function __construct(MongoDBConnection $mongo)
    {
        $this->mongo = $mongo;
    }

    public function write(string $level, string $action, string $message, string $actor_id, array $context): void
    {
        try {
            if ($this->collection === null) {
                $this->collection = $this->mongo->getCollection(
                    $_ENV['MONGO_DATABASE'],
                    $_ENV['MONGO_COLLECTION']
                );
            }

            $this->collection->insertOne([
                'level' => $level,
                'action' => $action,
                'message' => $message,
                'actor_id' => $actor_id,
                'context' => $context,
                'ip' => $_SERVER['REMOTE_ADDR'] ?? null,
                'time' => new \MongoDB\BSON\UTCDateTime(),
            ]);
        } catch (\Throwable $e) {
            error_log("MongoDB Logging Failed: " . $e->getMessage());
        }
    }
}