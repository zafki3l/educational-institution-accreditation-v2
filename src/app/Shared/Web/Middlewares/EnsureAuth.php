<?php

namespace App\Shared\Web\Middlewares;

use App\Shared\Web\Http\HttpResponse;

final class EnsureAuth
{
    use HttpResponse;

    public function handle(): void
    {
        if (!isAuth()) {
            $this->redirect('/login');
        }
    }
}