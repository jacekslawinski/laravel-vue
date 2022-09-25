<?php

declare(strict_types=1);

use App\Http\Controllers\HardwareController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

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

Route::group(['prefix' => 'hardware'], function () {
    Route::controller(HardwareController::class)->group(function () {
        Route::get('', 'index')->name('hardware.index');
        Route::delete('{hardware}', 'destroy')->name('hardware.destroy');
        Route::post('', 'store')->name('hardware.store');
        Route::put('{hardware}', 'update')->name('hardware.update');
        Route::delete('user/{hardware}', 'deleteUserHardware')->name('hardware.delete_user_hardware');
        Route::post('/user/{hardware}', 'addUserHardware')->name('hardware.add_user_hardware');
    });
});

Route::group(['prefix' => 'system'], function () {
    Route::controller(SystemController::class) ->group(function() {
        Route::get('', 'index')->name('system.index');
        Route::delete('{system}', 'destroy')->name('system.destroy');
        Route::post('', 'store')->name('system.store');
        Route::put('{system}', 'update')->name('system.update');
    });
});

Route::group(['prefix' => 'user'], function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('', 'index')->name('user.index');
        Route::delete('{user}', 'destroy')->name('user.destroy');
        Route::post('', 'store')->name('user.store');
        Route::put('{user}', 'update')->name('user.update');
    });
});

Route::fallback(function () {
    throw new RouteNotFoundException('Błędny url');
});
