<?php

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

Route::group(['middleware' => 'jwt.auth'], function () {
	// get information user login
	Route::get('auth/user', 'JWTAuthController@user');

	// logout invalidate token user
	Route::get('auth/logout', 'JWTAuthController@logout');

	Route::post('/upload', ['uses' => 'JWTAuthController@upload']);

	// list group by user
	Route::get('/groups', ['uses' => 'Api\GroupController@GroupByUser'])->name('group.byUser');

	// User follow group
	Route::post('/userfollow', ['uses' => 'Api\GroupMemberController@follow'])->name('user.follow');

	// User unfollow group
	Route::post('/userUnfollow', ['uses' => 'Api\GroupMemberController@followDenied'])->name('user.Unfollow');
	// featured hastag
	Route::post('/newfeed', ['uses' => 'Api\GroupController@newfeed']);
	Route::post('/change_password', ['uses' => 'JWTAuthController@change_password']);

});

// Refesh token user login
Route::middleware('jwt.refresh')->get('/token/refresh', 'JWTAuthController@refresh');

// login social facebook, google
Route::get('/redirect/{service}', 'SocialAuthController@redirect');
Route::get('/callback/{service}', 'SocialAuthController@callback');

// register user app
Route::post('user/register', 'JWTAuthController@register');
Route::post('user/login', 'JWTAuthController@login');
