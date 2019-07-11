<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

//Route::get('/email', function () {
//  $user = NewUserReq::first();
//  $setting = Setting::all()->first();
//  return view('mails.NewUserRequestReceived', ["setting" => $setting, "user" => $user]);
//});

Route::get('/{any?}', function () {
  return view('app');
})->where('any', '^(?!api).*$')->name("management");

