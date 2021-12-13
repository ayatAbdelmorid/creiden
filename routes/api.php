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
Route::group(['prefix'=>'userApi' ], function () {
    Route::post('/register', 'AuthUser\AuthController@storeUser');
    Route::post('/login', 'AuthUser\AuthController@authenticate');
    Route::post('/logout', 'AuthUser\AuthController@logout');
    });

//admin Auth
Route::group(['prefix'=>'adminApi'], function(){

    Route::post('/register', 'AuthAdmin\AuthController@storeUser');
    Route::post('/login', 'AuthAdmin\AuthController@authenticate');
    Route::post('logout', 'AuthAdmin\AuthController@logout')->middleware('auth:adminApi');
    //user Crud
    Route::resource('users', 'UserController')->middleware('adminApi')->except(['destroy','edit','create']);
    Route::get('/users/{user}/delete', 'UserController@destroy')->middleware('adminApi')->name('destroy');

    //storage Crud
    Route::resource('storages', 'StorageController')->middleware('adminApi')->except(['destroy','edit','create']);
    Route::get('/storages/{storage}/delete', 'StorageController@destroy')->middleware('adminApi')->name('storage.destroy');
    
});


Route::group(['middleware' => ['userApi','adminApi']], function () {
     

        //items
        Route::resource('{storage}/items', 'ItemController')->except(['destroy']);
        Route::get('/{storage}/items/{item}/delete', 'ItemController@destroy')->name('item.destroy');


});


