<?php

namespace App\Modules\Home\Presentation\Controllers;

use App\Shared\Web\Http\HttpResponse;
use App\Shared\Web\Responses\ViewResponse;

class HomeController
{
    use HttpResponse;

    private const MODULE_NAME = 'Home';

    public function index(): ViewResponse
    {
        return new ViewResponse(
            self::MODULE_NAME,
            'homepage/main', 
            'main.layouts',
            [
                'title' => 'Trang chủ | ' . SYSTEM_NAME
            ]
        );
    }
}