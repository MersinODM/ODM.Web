<?php

use Illuminate\Support\Facades\Route;

Route::get('/password/reset/{token}', 'Auth\CustomPasswordResetController@showResetForm')
    ->name("show_password_reset");
Route::post('/password/reset', 'Auth\CustomPasswordResetController@reset')
    ->name("reset_password");

Route::get('/{any?}', 'App\AppController@app')
    ->where('any', '^(?!api|password\/reset).*$')
    ->name("management");

