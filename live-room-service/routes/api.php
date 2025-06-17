<?php

use App\Http\Controllers\API\RoomController;
use Illuminate\Support\Facades\Route;

Route::apiResource('rooms', RoomController::class);
Route::get('rooms/filter/option', [RoomController::class,'filter']);

