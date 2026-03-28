<?php

namespace App\Shared\Infrastructure\Persistence;

use MongoDB\Client;
use MongoDB\Collection;

class MongoDBConnection
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client(
            "mongodb://mongo:{$_ENV['MONGO_PORT']}", [
                'serverSelectionTimeoutMS' => 500, 
                'connectTimeoutMS' => 500
            ]);
    }

    public function getCollection(string $db, string $collection): Collection
    {
        return $this->client->selectDatabase($db)->selectCollection($collection);
    }
}