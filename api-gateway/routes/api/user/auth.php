<?php

use Illuminate\Support\Facades\Route;
use Domain\api\user\customer\Controllers\CustomerController;

Route::controller(CustomerController::class)->group(function () {
    Route::post('user/auth/register', 'register');
    Route::post('user/auth/login', 'login');
});
