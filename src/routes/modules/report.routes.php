<?php

use App\Modules\Report\Presentation\Controllers\EvidenceWithoutFileController;
use App\Modules\Report\Presentation\Controllers\TotalEvidenceByDepartmentController;
use App\Modules\Report\Presentation\Controllers\TotalStandardByDepartmentController;
use App\Shared\Web\Middlewares\EnsureAuth;
use App\Shared\Web\Middlewares\EnsureStaff;

$route->middleware([EnsureAuth::class, EnsureStaff::class])
    ->get('/api/departments/evidences', [TotalEvidenceByDepartmentController::class, 'getTotal']);

$route->middleware([EnsureAuth::class, EnsureStaff::class])
    ->get('/api/departments/{id}/standards', [TotalStandardByDepartmentController::class, 'totalByDepartment']);

$route->middleware([EnsureAuth::class, EnsureStaff::class])
    ->get('/api/departments/standards', [TotalStandardByDepartmentController::class, 'totalByAllDepartment']);

$route->middleware([EnsureAuth::class, EnsureStaff::class])
    ->get('/api/evidences/without-file', [EvidenceWithoutFileController::class, 'totalWithoutFile']);

$route->middleware([EnsureAuth::class, EnsureStaff::class])
    ->get('/api/staff/standards', [TotalStandardByDepartmentController::class, 'standardsByStaffDepartment']);