<?php

namespace App\Shared\Infrastructure\Utils;

class UuidGenerator
{
    public static function v4(): string
    {
        $data = random_bytes(16);

        // version 4
        $data[6] = chr((ord($data[6]) & 0x0f) | 0x40);
        // variant RFC 4122
        $data[8] = chr((ord($data[8]) & 0x3f) | 0x80);

        $hex = bin2hex($data);

        $uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split($hex, 4));

        return $uuid;
    }
}