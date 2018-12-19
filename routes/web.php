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

Route::get('/', function () {
	return view('welcome');
});

Route::Resource('/groups', 'GroupController');

Route::group(['prefix' => 'groups'], function () {
	Route::Resource('/{group}/feeds', 'FeedController');
	Route::Resource('/{group}/members', 'GroupMemberController');
	Route::post('store', 'GroupController@store')->name('groups.store');
	Route::get('destroy/{id}', 'GroupController@destroy')->name('groups.destroy');
	Route::get('feed/destroy/{id}', 'FeedController@destroy')->name('feeds.destroy');
});
Route::get('feeduser', 'FeedController@feeduser')->name('feeduser');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/send-message', 'ChatRoomController@index');
