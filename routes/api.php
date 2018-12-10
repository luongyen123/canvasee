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
    Route::get('auth/user', 'JWTAuthController@user');
    Route::get('auth/logout', 'JWTAuthController@logout');
	Route::post('/upload', [ 'uses' => 'JWTAuthController@upload']);

	Route::get('/groups',['uses'=>'Api\GroupController@GroupByUser'])->name('group.byUser');
});

Route::middleware('jwt.refresh')->get('/token/refresh', 'JWTAuthController@refresh');

// 
Route::get ( '/redirect/{service}', 'SocialAuthController@redirect' );
Route::get ( '/callback/{service}', 'SocialAuthController@callback' );
Route::post('user/register', 'JWTAuthController@register');
Route::post('user/login', 'JWTAuthController@login');
