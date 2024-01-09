<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CountyController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);

});

Route::group(['middleware' => 'api', 'prefix' => 'account', 'namespace' => 'App\Http\Controllers'], function ($router) {

    Route::post('create', [AccountController::class, 'create']);
    Route::get('get/{email}', [AccountController::class, 'getAccount']);

});

Route::group(['middleware' => 'api', 'prefix' => 'favorite', 'namespace' => 'App\Http\Controllers'], function ($router) {

    Route::get('get/{id}', [FavoriteController::class, 'getFavorites']);
    Route::post('create', [FavoriteController::class, 'createFavorite']);

});

Route::group(['middleware' => 'api', 'prefix' => 'link', 'namespace' => 'App\Http\Controllers'], function ($router) {

    Route::get('all', [LinkController::class, 'getLinks']);

});

Route::group(['middleware' => 'api', 'prefix' => 'notification', 'namespace' => 'App\Http\Controllers'], function ($router) {

    Route::get('flash', [NotificationController::class, 'getFlashNotifications']);
    Route::get('unread', [NotificationController::class, 'getUnreadNotifications']);
    Route::get('read', [NotificationController::class, 'setReadNotifications']);
    Route::get('all', [NotificationController::class, 'getAllNotifications']);

});

Route::group(['middleware' => 'api', 'prefix' => 'users', 'namespace' => 'App\Http\Controllers'], function ($router) {

    Route::get('get/users', [UserController::class, 'getUsers']);
    Route::get('get/user/{id}', [UserController::class, 'getUser']);
    Route::get('get/empty/manager', [UserController::class, 'getEmptyManagerUsers']);
    Route::get('change/empty/manager/{id}', [UserController::class, 'changeEmptyManagerUser']);
    Route::post('change/no/empty/manager', [UserController::class, 'changeNoEmptyManagerUser']);
    Route::post('create/user', [UserController::class, 'createUser']);
    Route::patch('update/user', [UserController::class, 'updateUser']);
    Route::delete('delete/user/{id}', [UserController::class, 'deleteUser']);

});

Route::group(['middleware' => 'api', 'prefix' => 'counties', 'namespace' => 'App\Http\Controllers'], function ($router) {

    Route::get('get/counties', [CountyController::class, 'getCounties']);
    Route::get('get/county/{id}', [CountyController::class, 'getCounty']);
    Route::post('create/county', [CountyController::class, 'createCounty']);
    Route::delete('delete/county/{id}', [CountyController::class, 'deleteCounty']);
    Route::patch('update/county', [CountyController::class, 'updateCounty']);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
