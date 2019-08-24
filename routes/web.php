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

Auth::routes();

Route::group(['middleware' => 'auth'], function()
{
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('test', function(){
        return view('welcome');
    })->middleware('2fa');

    /** Google 2Fa */
    Route::get('/enable2fa', 'GoogleTwoFaController@enableForm');
    Route::get('/disable2fa', 'GoogleTwoFaController@disableForm')->middleware('2fa');
    Route::post('/generate2faSecret', 'GoogleTwoFaController@generate2faSecret')->name('generate2faSecret');
    Route::post('/2fa', 'GoogleTwoFaController@enable2fa')->name('enable2fa');
    Route::post('/disable2fa', 'GoogleTwoFaController@disable2fa')->name('disable2fa');
    Route::post('/2faVerify', function () {
        return redirect(URL()->previous());
    })->name('2faVerify')->middleware('2fa');
    /** Google 2Fa End */
});