<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByPath;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\Tenant\DashboardController;
use App\Http\Controllers\Tenant\ProjectController;
use App\Http\Controllers\Tenant\TaskController;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    'auth',
    InitializeTenancyByPath::class,
    \App\Http\Middleware\CheckTenantAccess::class,
])->prefix('t/{tenant}')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('tenant.dashboard');
    
    // Projects
    Route::resource('projects', ProjectController::class)->names([
        'index' => 'tenant.projects.index',
        'create' => 'tenant.projects.create',
        'store' => 'tenant.projects.store',
        'show' => 'tenant.projects.show',
        'edit' => 'tenant.projects.edit',
        'update' => 'tenant.projects.update',
        'destroy' => 'tenant.projects.destroy',
    ]);
    
    // Tasks
    Route::resource('tasks', TaskController::class)->names([
        'index' => 'tenant.tasks.index',
        'create' => 'tenant.tasks.create',
        'store' => 'tenant.tasks.store',
        'show' => 'tenant.tasks.show',
        'edit' => 'tenant.tasks.edit',
        'update' => 'tenant.tasks.update',
        'destroy' => 'tenant.tasks.destroy',
    ]);
});
