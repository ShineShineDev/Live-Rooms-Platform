<?php

use Illuminate\Support\Facades\Route;

Route::get("login", function () {
    return response()->json(["code" => -1, "message" => "Unauthorized"], 401);
})->name('login');

