<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['prefix'=>'user-api' ], function () {
    Route::post('/register', 'AuthUser\AuthController@storeUser');
    Route::post('/login', 'AuthUser\AuthController@authenticate');
    Route::post('/logout', 'AuthUser\AuthController@logout');



    
//     Route::get('/user/{user}/delete', 'UserController@destroy')->middleware('auth:admin')->name('destroy');
    
    });
//     //user Crud
// Route::resource('users', 'UserController')->middleware('auth:admin')->except(['destroy']);

//admin Auth
Route::group(['prefix'=>'admin-api'], function(){

    Route::post('/register', 'AuthAdmin\AuthController@storeUser');
    Route::post('/login', 'AuthAdmin\AuthController@authenticate');
    Route::post('logout', 'AuthAdmin\AuthController@logout');
});
    
// Route::group(['middleware' => ['auth:api']], function () {

// });

//storage Crud
// Route::resource('storages', 'StorageController')->middleware('auth:admin')->except(['destroy']);
// Route::get('/storage/{storage}/delete', 'StorageController@destroy')->middleware('auth:admin')->name('storage.destroy');

// Route::group(['prefix'=>'wordpress','as'=>'wordpress.','middleware' => ['auth:admin']], function(){

//     Route::get('/login', 'WordpressController@wordpressLogIn')->name('login');
//     // Route::get('/create_post', 'WordpressController@createPost')->name('createPost');
//     Route::get('/index_posts', 'WordpressController@index')->name('index_posts');
//     Route::get('/{post}/show_post', 'WordpressController@show')->name('show_post');
//     Route::get('/{post}/delete', 'WordpressController@destroy')->name('destroy_post');
//     Route::get('/edit_post/{post?}', 'WordpressController@edit')->name('edit_post');
//     Route::post('/store_post/{post?}', 'WordpressController@store')->name('store_post');

// });
// Route::resource('{storage}/items', 'ItemController')->middleware('auth:admin,user')->except(['destroy']);
// Route::get('/{storage}/items/{item}/delete', 'ItemController@destroy')->middleware('auth:admin,user')->name('item.destroy');
