<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes (Single Page Application Fallback)
|--------------------------------------------------------------------------
*/

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');
