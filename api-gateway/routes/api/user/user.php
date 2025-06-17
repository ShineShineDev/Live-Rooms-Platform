<?php


use Illuminate\Support\Facades\Route;

use Domain\api\user\customer\Controllers\CustomerController;

Route::middleware('auth:customer')->group(function () {
    Route::controller(CustomerController::class)->group(function () {
        Route::get('user/profile', 'profile');
        Route::delete('user/delete', 'delete');
        Route::post('user/update/password', 'updatePassword');
        Route::post('user/update/avatar', 'updateAvatar');
        Route::post('user/update', 'update');
    });
});
require base_path('routes/api/user/auth.php');
