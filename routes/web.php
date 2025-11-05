<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Central\OrganizationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return redirect()->route('organizations.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Cache management route (for Railway/Production)
Route::get('/clear-cache', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    \Illuminate\Support\Facades\Artisan::call('optimize');
    
    return response()->json([
        'message' => 'Cache cleared successfully!',
        'commands_run' => [
            'optimize:clear',
            'optimize'
        ]
    ]);
})->name('cache.clear');

Route::middleware('auth')->group(function () {
    
    Route::prefix('profile')->name('profile.')
     ->controller(ProfileController::class)->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });
    
    Route::prefix('organizations')->name('organizations.')
        ->controller(OrganizationController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('/{tenant}/switch', 'switch')->name('switch');
        });

});

require __DIR__.'/auth.php';
