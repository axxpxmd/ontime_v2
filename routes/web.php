<?php

use Illuminate\Support\Facades\Route;

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

// Auth
Route::get('/login', 'AuthController@index')->name('auth.index')->middleware('guest');
Route::post('/login', 'AuthController@login')->name('login')->middleware('guest');

// Home
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::post('/logout', 'AuthController@logout')->name('logout');

    Route::get('kehadiran', 'PresensiController@index')->name('kehadiran');
    Route::post('kehadiaran/get-data-absen', 'PresensiController@getDataAbsen')->name('kehadiran.getDataAbsen');
    Route::patch('kehadiran/update-absen/{id}', 'PresensiController@updateAbsen')->name('kehaidran.updateAbsen');
});
