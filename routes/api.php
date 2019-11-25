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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('continent', 'ContinentController');
Route::apiResource('roles', 'RolesController');
Route::apiResource('permissions', 'PermissionsController');
Route::apiResource('country', 'CountryController');
Route::apiResource('state', 'StateController');
Route::apiResource('user', 'UserController');
Route::post('continent/{continent}/country', 'CountryController@store');

Route::group([

    'middleware' => ['api'],
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('social','AuthController@socialite');
    Route::post('logout', 'AuthController@logout');
    Route::post('register', 'AuthController@register');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
    Route::post('{user}/change-password', 'AuthController@changePassword');
    Route::post('forgot-password', 'AuthController@forgotPassword');
    Route::post('{user}/reset-password/{token}', 'AuthController@resetPassword');

});

Route::get('roles/{role}/permissions', 'RolesController@permissions');
Route::patch('roles/{role}/permissions', 'RolesController@managePermissions');


Route::get('messages', 'ConversationController@fetchMessages');
Route::post('messages', 'ConversationController@sendMessage');

Route::get('game', 'GameController@index');
Route::post('game', 'GameController@store');

Route::post('user/image', 'UserController@image');

//Route::get('messages', 'ConversationController@fetchMessages');
Route::get('private-messages/{id}', 'MessageController@messages');
Route::post('private-messages', 'MessageController@send');
