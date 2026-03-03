<?php

namespace App\Modules\UserProfile\Application\Requests;

interface UpdateUserProfileRequestInterface
{
    public function getFirstName(): string;
    
    public function getLastName(): string;

    public function getEmail(): ?string;
}