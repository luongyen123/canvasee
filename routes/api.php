<?php

use Illuminate\Http\Request;

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

Route::group(['middleware' => 'jwt.auth'], function(){
	// get information user login
    Route::get('auth/user', 'JWTAuthController@user');

    // logout invalidate token user
    Route::get('auth/logout', 'JWTAuthController@logout');

	Route::post('/upload_image', [ 'uses' => 'MediaController@upload_image']);
	Route::post('/upload_video', [ 'uses' => 'MediaController@upload_video']);
	Route::post('upload_link', [ 'uses' => 'MediaController@upload_link']);

	// list group by user
	Route::get('/groups',['uses'=>'Api\GroupController@GroupByUser'])->name('group.byUser');

	// User follow group
	Route::post('/userfollow',['uses'=>'Api\GroupMemberController@follow'])->name('user.follow');

	// User unfollow group
	Route::post('/userUnfollow',['uses'=>'Api\GroupMemberController@followDenied'])->name('user.Unfollow');

	Route::post('/chattingroom',['uses'=>'ChatRoomController@index']);

});

// Refesh token user login
Route::middleware('jwt.refresh')->get('/token/refresh', 'JWTAuthController@refresh');

// login social facebook, google
Route::get ( '/redirect/{service}', 'SocialAuthController@redirect' );
Route::get ( '/callback/{service}', 'SocialAuthController@callback' );

// register user app
Route::post('user/register', 'JWTAuthController@register');
Route::post('user/login', 'JWTAuthController@login');
