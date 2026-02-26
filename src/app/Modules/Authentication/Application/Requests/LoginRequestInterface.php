<?php

namespace App\Modules\Authentication\Application\Requests;

interface LoginRequestInterface
{
    public function getIdentifier(): string;

    public function getPassword(): string;
}