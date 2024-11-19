<?php

use Illuminate\Support\Facades\Route;


Route::middleware('GeoRestriction')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
});
Route::get('/geo-restricted', function () {
    return view('403');
})->name('geo-restricted');
