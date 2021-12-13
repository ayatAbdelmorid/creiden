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
// Route::get('/', function () {
//     return view('welcome');
// });
//admin Auth
// Route::group(['prefix'=>'user','as'=>'user.'], function(){

//     Route::get('/register', 'AuthUser\AuthController@register')->name('register');
//     Route::post('/register', 'AuthUser\AuthController@storeUser');
//     Route::get('/login', 'AuthUser\AuthController@login')->name('login');
//     Route::post('/login', 'AuthUser\AuthController@authenticate');
//     Route::get('logout', 'AuthUser\AuthController@logout')->middleware('auth:user')->name('logout');

//     Route::get('/home', 'AuthUser\AuthController@home')->middleware('auth:user')->name('home');
//     Route::get('/user/{user}/delete', 'UserController@destroy')->middleware('auth:admin')->name('destroy');

// });
// //user Crud
// Route::resource('users', 'UserController')->middleware('auth:admin')->except(['destroy']);

// //admin Auth
// Route::group(['prefix'=>'admin','as'=>'admin.'], function(){

//     Route::get('/register', 'AuthAdmin\AuthController@register')->name('register');
//     Route::post('/register', 'AuthAdmin\AuthController@storeUser');
//     Route::get('/login', 'AuthAdmin\AuthController@login')->name('login');
//     Route::post('/login', 'AuthAdmin\AuthController@authenticate');
//     Route::get('logout', 'AuthAdmin\AuthController@logout')->middleware('auth:admin')->name('logout');

//     Route::get('/home', 'AuthAdmin\AuthController@home')->middleware('auth:admin')->name('home');
// });
// //storage Crud
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
