<?php


use App\Http\Controllers\MessagingController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:admin'], function () {
    Route::get('/', [MessagingController::class, 'index'])->name('admin.messaging.index');
    Route::get('/unicast/show-form/{c_id}', [MessagingController::class, 'showUnicastForm'])->name('admin.messaging.unicast.show-form');

    Route::post('/broadcast/send', [MessagingController::class, 'sendAsBroadcast'])->name('admin.messaging.broadcast.send');

    Route::post('/unicast/send', [MessagingController::class, 'sendAsUnicast'])->name('admin.messaging.unicast.send');
    Route::get('/history', [MessagingController::class, 'history'])->name('admin.messaging.history');
    Route::delete('/delete/{id}', [MessagingController::class, 'delete'])->name('admin.messaging.delete');
});

