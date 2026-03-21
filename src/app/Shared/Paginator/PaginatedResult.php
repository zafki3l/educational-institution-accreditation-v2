<?php

namespace App\Shared\Paginator;

class PaginatedResult
{
    public function __construct(
        public array $items,
        public int $currentPage,
        public int $perPage,
        public int $total,
        public int $lastPage,
    ) {}
}