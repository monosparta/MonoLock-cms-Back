<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LockerController;
use App\Http\Controllers\RecordController;
use App\Http\Middleware\Localization;
use App\Http\Middleware\UnlockMiddleware;
use App\Http\Middleware\EnsurePermissionIsRoot;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware([Localization::class])->group(function () {
    Route::post('login', [UserController::class, 'login']);
    Route::get('logout', [UserController::class, 'logout']);

    Route::middleware([EnsurePermissionIsRoot::class])->group(function () {
        Route::get('admin', [AdminController::class, 'index']);
        Route::post('admin', [AdminController::class, 'store']);
        Route::patch('admin/{id}', [AdminController::class, 'update']);
        Route::delete('admin/{id}', [AdminController::class, 'destroy']);

        Route::get('user', [UserController::class, 'index']);
        Route::post('user', [UserController::class, 'store']);
        Route::patch('user/{id}', [UserController::class, 'update']);
        Route::delete('user/{id}', [UserController::class, 'destroy']);

        Route::get('locker', [LockerController::class, 'index']);
        Route::patch('locker/{lockerNo}', [LockerController::class, 'update']);
        
        Route::post('unlock', [LockerController::class, 'unlock']);

        Route::get('record/{lockerNo}', [RecordController::class, 'show']);
    });

    Route::middleware([UnlockMiddleware::class])->group(function () {
        Route::post('RPIunlock', [LockerController::class, 'RPIunlock']);
        Route::get('RPIList', [LockerController::class, 'RPIList']);
    });
});
