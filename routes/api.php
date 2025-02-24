<?php


use App\Http\Controllers\v1\WeatherController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'v1','namespace'=>'App\Http\Controllers\v1\WeatherController','middleware'=>['throttle:weather']],function(){
    Route::get('/weather',WeatherController::class);
});

Route::get('/flush', function () {
    Cache::flush();
});
