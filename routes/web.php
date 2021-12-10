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

Route::get('/', function () {
    return view('welcome');
});
//admin Auth
Route::group(['prefix'=>'user','as'=>'user.'], function(){

    Route::get('/register', 'AuthUser\AuthController@register')->name('register');
    Route::post('/register', 'AuthUser\AuthController@storeUser');
    Route::get('/login', 'AuthUser\AuthController@login')->name('login');
    Route::post('/login', 'AuthUser\AuthController@authenticate');
    Route::get('logout', 'AuthUser\AuthController@logout')->name('logout');

    Route::get('/home', 'AuthUser\AuthController@home')->name('home');
});


Route::group(['prefix'=>'admin','as'=>'admin.'], function(){

    Route::get('/register', 'AuthAdmin\AuthController@register')->name('register');
    Route::post('/register', 'AuthAdmin\AuthController@storeUser');
    Route::get('/login', 'AuthAdmin\AuthController@login')->name('login');
    Route::post('/login', 'AuthAdmin\AuthController@authenticate');
    Route::get('logout', 'AuthAdmin\AuthController@logout')->name('logout');

    Route::get('/home', 'AuthAdmin\AuthController@home')->name('home');
});
