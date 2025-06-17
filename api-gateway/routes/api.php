<?php

use App\Http\Controllers\FileUploadController;
use Domain\api\common\Controllers\BannerController;
use App\Http\Controllers\ApiGatewayController;
use Illuminate\Support\Facades\Route;


Route::any('/gateway/pub/{serviceName}/{path?}', [ApiGatewayController::class, 'proxyRequest'])
    ->where('serviceName', '[a-zA-Z0-9\-_]+')
    ->where('path', '.*');

Route::middleware('auth:customer')->group(function () {
    Route::any('/gateway/{serviceName}/{path?}', [ApiGatewayController::class, 'proxyRequest'])
        ->where('serviceName', '[a-zA-Z0-9\-_]+')
        ->where('path', '.*');
});

Route::any('/health-check', function () {
    return 1;
});


// Route::get("banners", [BannerController::class, 'getAll']);
// Route::controller(FileUploadController::class)->group(function () {
//     Route::post('file/upload', 'upload')->middleware("auth:admin");
//     Route::get('file', 'fileLists')->middleware("auth:admin");
// });
// Route::post("banners", [BannerController::class, 'store'])->middleware("auth:admin");
// Route::post("banners/update/{id}", [BannerController::class, 'update'])->middleware("auth:admin");
// Route::delete("banners/delete/{id}", [BannerController::class, 'destory'])->middleware("auth:admin");