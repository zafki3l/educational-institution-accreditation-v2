<?php

namespace Tests\TraitHelper;

trait DebugHelper
{
    protected function debug(string $title, mixed $data): void
    {
        fwrite(STDERR, "\n--- $title ---\n");
        fwrite(STDERR, print_r($data, true));
        fwrite(STDERR, "\n-------------------\n");
    }
}