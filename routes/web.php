<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes (Single Page Application Fallback)
|--------------------------------------------------------------------------
|
| The catch-all route ensures that any frontend URL (e.g. /resume, /project/slug,
| /admin/dashboard) serves the SPA Blade template, while completely excluding
| /api/* so invalid API calls return proper JSON 404 responses.
|
*/

Route::get('/{any}', function () {
    return view('app');
})->where('any', '^(?!api).*$');
