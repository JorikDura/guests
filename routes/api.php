<?php

use App\Http\Controllers\Api\V1\Countries\CountriesIndexController;
use App\Http\Controllers\Api\V1\Guests\GuestsDeleteController;
use App\Http\Controllers\Api\V1\Guests\GuestsIndexController;
use App\Http\Controllers\Api\V1\Guests\GuestsShowController;
use App\Http\Controllers\Api\V1\Guests\GuestsStoreController;
use App\Http\Controllers\Api\V1\Guests\GuestsUpdateController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'guests'], function () {
        Route::get('/', GuestsIndexController::class);
        Route::post('/', GuestsStoreController::class);
        Route::get('/{guest}', GuestsShowController::class);
        Route::put('/{guest}', GuestsUpdateController::class);
        Route::delete('/{guest}', GuestsDeleteController::class);
    });
    Route::get('/countries', CountriesIndexController::class);
});
