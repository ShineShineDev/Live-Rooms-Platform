<?php

use App\Http\Controllers\API\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::post('subscribe', [SubscriptionController::class, 'store']);
Route::get('subscribe/list', [SubscriptionController::class, 'list']);

