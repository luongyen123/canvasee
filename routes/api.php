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
	//change password
	Route::post('/change_password', ['uses' => 'JWTAuthController@change_password']);

	Route::post('/chattingroom',['uses'=>'ChatRoomController@store']);
	//get ip client
	Route::post('/getIP',['uses'=>'JWTAuthController@getIP']);
	//related hastag
	Route::post('/related',['uses'=>'Api\GroupController@related']);
	//popular hastag
	Route::get('/popular',['uses'=>'Api\FeedController@popular']);
	//create feed
	Route::post('creat_feed',['uses'=>'Api\FeedController@create']);
	/*Private message url*/

	// Route::post('get-private-message-notifications','PrivateMessageController@getUserNotifications');
	// Route::post('get-private-messages','PrivateMessageController@getPrivateMessages');
	// Route::post('get-private-message','PrivateMessageController@getPrivateMessageById');
	// Route::post('get-private-messages-sent','PrivateMessageController@getPrivateMessageSent');
	// Route::post('sen-private-message','PrivateMessageController@sendPrivateMessage');

});
Route::post('/chattingroom',['uses'=>'ChatRoomController@store']);

// Refesh token user login
Route::middleware('jwt.refresh')->get('/token/refresh', 'JWTAuthController@refresh');

// login social facebook, google
Route::get('/redirect/{service}', 'SocialAuthController@redirect');
Route::get('/callback/{service}', 'SocialAuthController@callback');

// register user app
Route::post('user/register', 'JWTAuthController@register');
Route::post('user/login', 'JWTAuthController@login');
