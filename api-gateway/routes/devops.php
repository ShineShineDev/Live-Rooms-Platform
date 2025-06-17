<?php

use App\Http\Controllers\dev\DevOperationController;

use App\Http\Controllers\SystemMonitorController;
use Illuminate\Support\Facades\Route;

Route::middleware('check.devops.token')->group(function () {
    Route::post('run-sql', [DevOperationController::class, 'runSQL']);
    Route::post('deploy', [DevOperationController::class, 'deploy']);
});

Route::get('/monitor', [SystemMonitorController::class, 'index']);
Route::get('/monitor/data', [SystemMonitorController::class, 'getMonitorData']);

Route::get('/uPYmRbQbtnOwFKuPJfHSkDyPOsKYEnZhaWJwERuFgYLCLQ/c-c', function () {
    Artisan::call('cache:clear');        // Clear application cache
    Artisan::call('config:clear');       // Clear config cache
    Artisan::call('route:clear');        // Clear route cache
    Artisan::call('view:clear');         // Clear view cache
    return 'All caches have been cleared!';
});
Route::get('/uPYmRbQbtnOwFKuPJfHSkDyPOsKYEnZhaWJwERuFgYLCLQ/storage-link', function () {
    Artisan::call('storage:link');
    return 'Storage link created!';
});