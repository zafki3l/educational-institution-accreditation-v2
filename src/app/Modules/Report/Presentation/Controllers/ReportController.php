<?php

namespace App\Modules\Report\Presentation\Controllers;

use App\Shared\Http\Traits\HttpResponse;

abstract class ReportController
{
    use HttpResponse;
    
    public const MODULE_NAME = 'Report'; 
}